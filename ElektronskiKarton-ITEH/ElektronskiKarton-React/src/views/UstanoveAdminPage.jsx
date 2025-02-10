import { Fragment, useState, useEffect } from "react";
import { Form } from "react-bootstrap";
import axiosClient from "../axios/axios-client";

export default function UstanovePage() {
  const [ustanove, setUstanove] = useState([]);
  const [searchNaziv, setSearchNaziv] = useState("");
  const [searchMesto, setSearchMesto] = useState("");
  const [mesta, setMesta] = useState([]);
  const [showAddForm, setShowAddForm] = useState(false);
  const [newUstanova, setNewUstanova] = useState({
    naziv: "",
    ulicaBroj: "",
    mesto_postanskiBroj: "", // Promenili smo ovo u postanski broj
  });

  // Učitavanje mesta
  useEffect(() => {
    const fetchMesta = async () => {
      try {
        const response = await axiosClient.get("mesta");
        setMesta(response.data.data);
      } catch (error) {
        console.log("Došlo je do greške pri učitavanju mesta", error);
      }
    };
    fetchMesta();
  }, []);

  // Učitavanje ustanova sa API-ja sa parametrima
  useEffect(() => {
    const fetchData = async () => {
      try {
        let url = "ustanove";
        const searchParams = new URLSearchParams();

        if (searchNaziv) searchParams.append("naziv", searchNaziv);
        if (searchMesto) searchParams.append("mesto", searchMesto);

        if (searchParams.toString()) {
          url = `${url}?${searchParams.toString()}`;
        }

        const response = await axiosClient.get(url);
        setUstanove(response.data.data);
      } catch (error) {
        console.log("Došlo je do greške pri učitavanju ustanova", error);
      }
    };

    fetchData();
  }, [searchNaziv, searchMesto]);

  const handleAddUstanova = async () => {
    try {
      // Dodajemo mesto_postanskiBroj umesto mesto
      const newUstanovaData = {
        naziv: newUstanova.naziv,
        ulicaBroj: newUstanova.ulicaBroj,
        mesto_postanskiBroj: newUstanova.mesto_postanskiBroj, // koristimo postanski broj
      };
      console.log(newUstanovaData);
      console.log()

      const response = await axiosClient.post("ustanove", newUstanovaData);
      setUstanove([...ustanove, response.data]);
      setShowAddForm(false);
      setNewUstanova({ naziv: "", ulicaBroj: "", mesto_postanskiBroj: "" });
    } catch (error) {
      console.log("Došlo je do greške pri dodavanju ustanove", error);
    }
  };

  return (
    <Fragment>
      <div className="mainBanner">
        <div className="forme">
          <Form.Group className="filterForma" controlId="searchNaziv">
            <Form.Label className="title">Pretraga po Nazivu</Form.Label>
            <Form.Control
              className="formInput"
              type="text"
              placeholder="Unesite naziv"
              value={searchNaziv}
              onChange={(e) => setSearchNaziv(e.target.value)}
            />
          </Form.Group>

          <Form.Group className="mb-3" controlId="searchMesto">
            <Form.Label className="title">Pretraga po Mestu</Form.Label>
            <Form.Control
              className="formSelect"
              as="select"
              value={searchMesto}
              onChange={(e) => setSearchMesto(e.target.value)}
            >
              <option value="">Izaberite mesto</option>
              {mesta && mesta.length > 0 ? (
                mesta.map((mesto) => (
                  <option
                    key={mesto.postanskiBroj}
                    value={mesto.postanskiBroj}
                  >
                    {mesto.naziv}
                  </option>
                ))
              ) : (
                <option value="">Nema mesta</option>
              )}
            </Form.Control>
          </Form.Group>

          {/* Dodavanje nove ustanove */}
          <button
            type="button"
            className="btn btn-primary"
            onClick={() => setShowAddForm(!showAddForm)}
          >
            Dodaj novu ustanovu
          </button>

          {showAddForm && (
            <div className="add-form">
              <Form.Group controlId="naziv">
                <Form.Label>Naziv</Form.Label>
                <Form.Control
                  type="text"
                  value={newUstanova.naziv}
                  onChange={(e) =>
                    setNewUstanova({ ...newUstanova, naziv: e.target.value })
                  }
                  placeholder="Naziv ustanove"
                />
              </Form.Group>

              <Form.Group controlId="ulicaBroj">
                <Form.Label>Ulica i broj</Form.Label>
                <Form.Control
                  type="text"
                  value={newUstanova.ulicaBroj}
                  onChange={(e) =>
                    setNewUstanova({
                      ...newUstanova,
                      ulicaBroj: e.target.value,
                    })
                  }
                  placeholder="Ulica i broj"
                />
              </Form.Group>

              <Form.Group controlId="mesto">
                <Form.Label>Mesto</Form.Label>
                <Form.Control
                  as="select"
                  value={newUstanova.mesto_postanskiBroj} // Menjamo ovo
                  onChange={(e) =>
                    setNewUstanova({
                      ...newUstanova,
                      mesto_postanskiBroj: e.target.value,
                    })
                  }
                >
                  <option value="">Izaberite mesto</option>
                  {mesta && mesta.length > 0 ? (
                    mesta.map((mesto) => (
                      <option
                        key={mesto.postanskiBroj}
                        value={mesto.postanskiBroj} // Koristimo postanskiBroj
                      >
                        {mesto.naziv}
                      </option>
                    ))
                  ) : (
                    <option value="">Nema mesta</option>
                  )}
                </Form.Control>
              </Form.Group>

              <button
                type="button"
                className="btn btn-success"
                onClick={handleAddUstanova}
              >
                Dodaj
              </button>
            </div>
          )}
        </div>

        {/* Prikazivanje ustanova */}
        <div className="ustanoveContainer">
          {ustanove && ustanove.length > 0 ? (
            ustanove.map((value, index) => (
              <div className="custom-card" key={`ustanova-${index}`}>
                {Object.entries(value)
                  .slice(1)
                  .map(([key, val]) => (
                    <div key={`${key}-${val}`}>
                      <h1 className="title">{formatKeyLabel(key)}</h1>
                      <p className="text">{val}</p>
                    </div>
                  ))}
              </div>
            ))
          ) : (
            <p className="alert-message">Nema mesta sa odabranim filterom</p>
          )}
        </div>
      </div>
    </Fragment>
  );
}

function formatKeyLabel(key) {
  const labels = {
    naziv: "Naziv",
    ulicaBroj: "Ulica i broj",
    mesto_postanskiBroj: "Mesto", // Menjamo naziv za postanski broj
  };
  return (
    labels[key] ||
    key
      .replace(/([A-Z])/g, " $1")
      .charAt(0)
      .toUpperCase() + key.slice(1)
  );
}
