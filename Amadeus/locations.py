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
    response = amadeus.reference_data.locations.get(
        subType='CITY',
        keyword='braga',
    )
    results = response.result['data']


except ResponseError as error:
    print(error)

f = open("Amadeus/locations.json", "w")
f.write(json.dumps(results))

f.close()
