import sys
import pymongo
import numpy as np
import pandas as pd
import matplotlib.pyplot as plt
from joblib import dump, load
from sklearn import neighbors, svm, metrics
from sklearn.linear_model import LogisticRegression
from sklearn.cluster import KMeans
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import LabelEncoder, scale

client = pymongo.MongoClient("mongodb://localhost")
db = client.hotelbeds

collection = db["38.7123_-9.13833_2020-10-20_2020-10-21_1_2_0"]

fields = collection.find(
    {"minRate": {"$exists": True}, "categoryCode": {"$in": ["1EST", "2EST", "3EST", "4EST", "5EST"]}}, {"_id": 0, "minRate": 1, "distance_center": 1, "score": 1, "categoryCode": 1, "latitude": 1, "longitude": 1})

df = pd.DataFrame(list(fields))

# convert categoryCode to int
df["categoryCode"] = df["categoryCode"].str[0].astype(int)

# convert minRate to int range
bins = np.linspace(0, 200, num=7, dtype=int, endpoint=True)
bins = np.append(bins, 999)
df['minRate'] = pd.cut(df['minRate'], bins, right=True, labels=False)

print(bins)
print(df['minRate'])

# df.plot(x='distance_center', y='minRate', kind='scatter')
# df.plot(x='score', y='minRate', kind='scatter')
# df.plot(x='categoryCode', y='minRate', kind='scatter')
# plt.show()

# features
X = df[['latitude', 'longitude']].to_numpy()
# label
y = df['minRate'].to_numpy()

# create model
# KNN
knn = neighbors.KNeighborsClassifier(n_neighbors=25, weights='uniform')
# SVM
svm_model = svm.SVC()
# Logistic Regression
logis = LogisticRegression(max_iter=1000)
# KMeans
kmeans = KMeans(n_clusters=7, random_state=0)

X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2)

knn.fit(X_train, y_train)
svm_model.fit(X_train, y_train)
logis.fit(X_train, y_train)
kmeans.fit(X_train)

knn_prediction = knn.predict(X_test)
svm_prediction = svm_model.predict(X_test)
logis_prediction = logis.predict(X_test)
kmeans_prediction = kmeans.predict(X_test)


knn_accuracy = metrics.accuracy_score(y_test, knn_prediction)
svm_accuracy = metrics.accuracy_score(y_test, svm_prediction)
logis_accuracy = metrics.accuracy_score(y_test, logis_prediction)
kmeans_accuracy = metrics.accuracy_score(y_test, kmeans_prediction)


print("KNN accuracy:", knn_accuracy)
print("SVM accuracy:", svm_accuracy)
print("Logis accuracy:", logis_accuracy)
print("kmeans accuracy:", kmeans_accuracy)
