import socket
import sys

# python client.py 38.7123_-9.13833_2020-10-25_2020-10-26_1_2_0
# python client.py 38.7123_-9.13833_2020-11-02_2020-11-05_1_2_0

data = sys.argv[1]

HOST = '127.0.0.1'
PORT = 65432
bufsize = 1024

s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
s.connect((HOST, PORT))
s.sendall(data.encode('utf-8'))

R2 = s.recv(bufsize).decode()

print(R2)

s.close()
