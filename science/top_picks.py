def top_picks(collection):
    import pymongo
    import numpy as np
    import pandas as pd
    from scipy import stats
    import statsmodels.api as sm
    from sklearn import neighbors, metrics
    from sklearn.preprocessing import MinMaxScaler
    import sys

    # GET DATA
    client = pymongo.MongoClient("mongodb://localhost")
    db = client.hotelbeds

    collection = db[collection]

    fields = collection.find(
        {"minRate": {"$exists": True}, "categoryCode": {"$in": ["1EST", "2EST", "3EST", "4EST", "5EST"]}}, {"_id": 0, "code": 1, "minRate": 1, "score": 1, "categoryCode": 1, "latitude": 1, "longitude": 1})

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
    # location score: 1, 2, 3, 4 or 5
    n_class = 5
    quantiles = np.linspace(0, 1,
                            num=n_class+1, endpoint=True)
    bins = np.quantile(df["rate_control"], quantiles)
    df["location"] = pd.cut(df["rate_control"], bins,
                            right=True, include_lowest=True, labels=[1, 2, 3, 4, 5])

    # KNN LOCATION SCORE
    n_neighbors = 4
    weights = 'uniform'

    knn = neighbors.KNeighborsClassifier(
        n_neighbors=n_neighbors, weights=weights)

    X = df[['longitude', 'latitude']].to_numpy()
    y = df['location'].to_numpy()

    knn.fit(X, y)
    df["loc_pred"] = knn.predict(X)
    # knn_accuracy = metrics.accuracy_score(y, df["loc_pred"])

    # FINAL MODEL
    X = df[['categoryCode', 'loc_pred', 'score_control']]

    X = pd.DataFrame(
        MinMaxScaler(
        ).fit_transform(X),  columns=X.columns, index=X.index)

    X_linear = sm.add_constant(X)

    y = df["minRate"]

    # LINEAR REGRESSION
    linear_model = sm.OLS(y, X_linear).fit()
    # print("R2 Linear  Model:", linear_model.rsquared)
    df["price_pred"] = linear_model.predict(X_linear)

    r2_predictions = metrics.r2_score(y, df["price_pred"])

    # print(linear_model.summary())

    # save
    df["discount"] = - np.minimum(df["minRate"] / df["price_pred"] - 1, 1)

    df["discount"] = (df["discount"] - min(df["discount"])) / \
        (max(df["discount"])-min(df["discount"]))*100

    for index in df.index:
        collection.update_one({"code": int(df["code"][index])}, {
            "$set": {"top_picks": df["discount"][index]}})

    # return R2
    return str(r2_predictions)


print(top_picks("38.7222524_-9.1393366_2021-03-01_2021-03-04_1_2_0"))
