from amadeus import Client, ResponseError
import json

amadeus = Client(
    # production key
    hostname='production',
    client_id='uAk2LEWrs0H7tMxRK1VNhO0SEaaesYNl',
    client_secret='9UhJH5Lr11SIAccU'
)


class results:
    def function(self):
        pass


results = []

try:
    response = amadeus.shopping.hotel_offers.get(
        cityCode='LIS',
        checkInDate='2020-07-02',
        checkOutDate='2020-07-03',
        adults=2,
        roomQuantity=1
    )
    results = response.result['data']

    while 'meta' in response.result:
        response = amadeus.next(response)
        results.extend(response.result['data'])
        if len(results) >= 300:
            break


except ResponseError as error:
    print(error)

f = open("Amadeus/hotel_offers.json", "w")
f.write(json.dumps(results))

f.close()
