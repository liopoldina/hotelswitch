import sys
import pymongo
import numpy as np
from scipy import stats
import pandas as pd
import matplotlib.pyplot as plt
from matplotlib.colors import ListedColormap
import statsmodels.api as sm
from statsmodels.stats.outliers_influence import variance_inflation_factor
from sklearn import neighbors, metrics
from sklearn.svm import SVR
from sklearn.linear_model import LinearRegression
from sklearn.linear_model import LassoCV
from sklearn.preprocessing import MinMaxScaler, PolynomialFeatures
from sklearn.pipeline import Pipeline, make_pipeline

# GET DATA
client = pymongo.MongoClient("mongodb://localhost")
db = client.hotelbeds

#collection = db["51.507538_-0.127804_2020-11-20_2020-11-21_1_2_0"]
collection = db["38.7123_-9.13833_2020-10-25_2020-10-26_1_2_0"]

fields = collection.find(
    {"minRate": {"$exists": True}, "categoryCode": {"$in": ["1EST", "2EST", "3EST", "4EST", "5EST"]}}, {"_id": 0, "code": 1, "minRate": 1, "distance_center": 1, "score": 1, "categoryCode": 1, "latitude": 1, "longitude": 1})

df = pd.DataFrame(list(fields))

# PREPROCESSING DATA
# categoryCode to int
df.categoryCode = df.categoryCode.str[0].astype(int)
# remove outliers
df = df[(np.abs(stats.zscore(df)) < 3).all(axis=1)]

# control rate and score for hotel stars
for i in range(min(df.categoryCode), max(df.categoryCode)+1):
    # scores
    df.loc[df.categoryCode == i, "score_control"] = df[df.categoryCode == i]["score"] * np.mean(
        df["score"])/np.mean(df[df.categoryCode == i]["score"])
    # rate
    df.loc[df.categoryCode == i, "rate_control"] = df[df.categoryCode == i]["minRate"] * np.mean(
        df["minRate"])/np.mean(df[df.categoryCode == i]["minRate"])

# CREATE LOCATION SCORE
# location score: 6, 7, 8, 9 ou 10
n_class = 5
quantiles = np.linspace(0, 1,
                        num=n_class+1, endpoint=True)
bins = np.quantile(df["rate_control"], quantiles)
df["location"] = pd.cut(df["rate_control"], bins,
                        right=True, include_lowest=True, labels=[6, 7, 8, 9, 10])

# KNN LOCATION SCORE
n_neighbors = 4
weights = 'uniform'

knn = neighbors.KNeighborsClassifier(
    n_neighbors=n_neighbors, weights=weights)

X = df[['longitude', 'latitude']].to_numpy()
y = df['location'].to_numpy()

knn.fit(X, y)
df["loc_pred"] = knn.predict(X)
knn_accuracy = metrics.accuracy_score(y, df["loc_pred"])
print("Knn Accuracy:", knn_accuracy)

# FINAL MODEL
X = df[['categoryCode', 'loc_pred', 'score_control']]

X = pd.DataFrame(
    MinMaxScaler(
    ).fit_transform(X),  columns=X.columns, index=X.index)

X_linear = sm.add_constant(X)

y = df["minRate"]

# LINEAR REGRESSION
linear_model = sm.OLS(y, X_linear).fit()
print("R2 Linear  Model:", linear_model.rsquared)

df["price_pred"] = linear_model.predict(X_linear)

r2_predictions = metrics.r2_score(y, df["price_pred"])

print("R2 Linear Predictions:", r2_predictions)

# test multicollinearity
variables = linear_model.model.exog
vif_linear_model = [variance_inflation_factor(variables, i)
                    for i in range(variables.shape[1])]

# NONLINEAR REGRESSION
poly_degree = 2

poly_features = PolynomialFeatures(
    poly_degree).fit(X)

feature_names = poly_features.get_feature_names(X.columns)

feature_names[0] = 'const'

X_poly = pd.DataFrame(poly_features.transform(
    X), columns=feature_names, index=X.index)

# poly variables to include
X_poly = X_poly[["const", "categoryCode^2", "categoryCode", "loc_pred^2", "loc_pred",
                 "score_control^2", "score_control", "categoryCode loc_pred", "categoryCode score_control", "loc_pred score_control"]]


nonlinear_model = sm.OLS(y, X_poly).fit()
print("R2 NonLinear  Model:", nonlinear_model.rsquared)

nonlinear_pred = nonlinear_model.predict(X_poly)

r2_predictions = metrics.r2_score(y, nonlinear_pred)
print("R2 NonLinear Predictions:", r2_predictions)

print(linear_model.summary())
print("VIF:", vif_linear_model)
print(nonlinear_model.summary())

# save and close
df["discount"] = (df["minRate"] / df["price_pred"] - 1)*100

df.to_excel(r'C:\Users\pedro\Desktop\df.xlsx', index=False)
X_poly.to_excel(r'C:\Users\pedro\Desktop\X_poly.xlsx', index=False)


sys.exit()
# FIGURES
X = df[['longitude', 'latitude']].to_numpy()
y = df['location'].to_numpy()

# plot decision boundary knn
h = .001  # step size in the mesh

# Create color maps
cmap = ListedColormap(
    ['red', 'orange', 'yellow', 'green', 'cyan'])

# Plot the decision boundary. For that, we will assign a color to each
# point in the mesh [x_min, x_max]x[y_min, y_max].
x_min, x_max = X[:, 0].min() - 0.05, X[:, 0].max() + 0.05
y_min, y_max = X[:, 1].min() - 0.05, X[:, 1].max() + 0.05
xx, yy = np.meshgrid(np.arange(x_min, x_max, h),
                     np.arange(y_min, y_max, h))
Z = knn.predict(np.c_[xx.ravel(), yy.ravel()])

# Put the result into a color plot
Z = Z.reshape(xx.shape)

plt.pcolormesh(xx, yy, Z, cmap=cmap)
plt.title("%i-Class classification (k = %i, weights = '%s')"
          % (n_class, n_neighbors, weights))
plt.savefig('C:\\Users\\pedro\\Desktop\\plot_images\\' + "MAP " +
            str(n_class) + "-Class " + str(n_neighbors) + (" Neighbors ") + weights + '.png')

# Plot training points (ACTUAL POINTS y)
plt.scatter(X[:, 0], X[:, 1], c=y, cmap=cmap,
            edgecolor='k', s=20)
plt.xlim(xx.min(), xx.max())
plt.ylim(yy.min(), yy.max())
plt.title("%i-Class classification (k = %i, weights = '%s')"
          % (n_class, n_neighbors, weights))
plt.savefig('C:\\Users\\pedro\\Desktop\\plot_images\\' + "ACTUAL " +
            str(n_class) + "-Class " + str(n_neighbors) + (" Neighbors ") + weights + '.png')

# Plot predictiosn points ( df["price_pred"])
plt.scatter(X[:, 0], X[:, 1], c=df["loc_pred"], cmap=cmap,
            edgecolor='k', s=20)
plt.xlim(xx.min(), xx.max())
plt.ylim(yy.min(), yy.max())
plt.title("%i-Class classification (k = %i, weights = '%s')"
          % (n_class, n_neighbors, weights))
plt.savefig('C:\\Users\\pedro\\Desktop\\plot_images\\' + "PREDICTION " +
            str(n_class) + "-Class " + str(n_neighbors) + (" Neighbors ") + weights + '.png')
