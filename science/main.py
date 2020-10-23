import sys
import pymongo
import math
import numpy as np
import pandas as pd
import matplotlib.pyplot as plt
from joblib import dump, load
from sklearn import neighbors, metrics
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import LabelEncoder


client = pymongo.MongoClient("mongodb://localhost")
db = client.hotelbeds

collection = db["38.7123_-9.13833_2020-10-19_2020-10-20_1_2_0"]

fields = collection.find(
    {"minRate": {"$exists": True}, "categoryCode": {"$in": ["1EST", "2EST", "3EST", "4EST", "5EST"]}}, {"_id": 0, "minRate": 1, "distance_center": 1, "score": 1, "categoryCode": 1, "latitude": 1, "longitude": 1})

df = pd.DataFrame(list(fields))

# convert categoryCode to int
df["categoryCode"] = df["categoryCode"].str[0].astype(int)


# features
X = df[['latitude', 'longitude']].to_numpy()
# label
y = df['minRate'].to_numpy()

# figures
df.plot(x='longitude', y='latitude', kind='scatter')

df.plot(x='longitude', y='latitude', kind='scatter', figsize=(
    10, 7), c=y, cmap=plt.get_cmap("jet"), colorbar=True)

plt.show()
