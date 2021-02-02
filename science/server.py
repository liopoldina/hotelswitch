import sys
import pymongo
import numpy as np
import pandas as pd
from scipy import stats
import statsmodels.api as sm
from sklearn import neighbors, metrics
from sklearn.preprocessing import MinMaxScaler
import socket
import top_picks as tp

HOST = '127.0.0.1'
PORT = 65432
bufsize = 1024

s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
s.bind((HOST, PORT))
s.listen()

while True:
    conn, addr = s.accept()
    data = conn.recv(bufsize).decode()
    if not data:
        break
    elif data == 'kill':
        conn.close()
        sys.exit()
    else:
        try:
            R2 = tp.top_picks(data)
            conn.sendall(R2.encode('utf-8'))
        except:
            msg = "erro"
            conn.sendall(msg.encode('utf-8'))

# Start Server
# Linux: python server.py &
# Windows: pythonw.exe server.py
