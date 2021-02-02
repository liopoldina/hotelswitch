import socket
import sys

# python client.py 38.7222524_-9.1393366_2021-03-01_2021-03-04_1_2_0

data = sys.argv[1]

HOST = '127.0.0.1'
PORT = 65432
bufsize = 1024

s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
s.connect((HOST, PORT))
s.sendall(data.encode('utf-8'))

msg = s.recv(bufsize).decode()

print(msg)

s.close()
