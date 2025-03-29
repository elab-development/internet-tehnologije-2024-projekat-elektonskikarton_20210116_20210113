import { Fragment, useState, useEffect } from "react";
import { Form } from "react-bootstrap";
import axiosClient from "../../axios/axios-client";
import Breadcrumb from "react-bootstrap/Breadcrumb";

export default function UstanoveBanner() {
  const [ustanove, setUstanove] = useState([]);
  const [searchNaziv, setSearchNaziv] = useState("");
  const [searchMesto, setSearchMesto] = useState("");
  const [mesta, setMesta] = useState([]);
  const [currentPage, setCurrentPage] = useState(1); // Track current page
  const [totalPages, setTotalPages] = useState(1); // Track total pages

  useEffect(() => {
    const fetchMesta = async () => {
      try {
        const response = await axiosClient.get("mesta");
        setMesta(response.data.data);
        console.log(response.data.data);
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

        // Adding pagination params to the URL
        searchParams.append("page", currentPage);
        searchParams.append("limit", 10); // Adjust limit based on how many items per page you want

        if (searchParams.toString()) {
          url = `${url}?${searchParams.toString()}`;
        }

        const response = await axiosClient.get(url);
        setUstanove(response.data.data);
        setTotalPages(response.data.meta.last_page); // Assuming the API returns totalPages
      } catch (error) {
        console.log("Došlo je do greške pri učitavanju ustanova", error);
      }
    };

    fetchData();
  }, [searchNaziv, searchMesto, currentPage]);

  // Handle page change
  const handlePageChange = (page) => {
    if (page >= 1 && page <= totalPages) {
      setCurrentPage(page);
    }
  };

  return (
    <Fragment>
      <div className="mainBanner">
      <Breadcrumb className="breadcrumb">
        <Breadcrumb.Item href="pocetna">Početna</Breadcrumb.Item>
        <Breadcrumb.Item active>Ustanove</Breadcrumb.Item>
      </Breadcrumb>
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
                  <option key={mesto.postanskiBroj} value={mesto.postanskiBroj}>
                    {mesto.naziv}
                  </option>
                ))
              ) : (
                <option value="">Nema mesta</option>
              )}
            </Form.Control>
          </Form.Group>
        </div>

          {/* Prikazivanje ustanova unutar overlay-a */}
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
    mesto: "Mesto",
  };
  return (
    labels[key] ||
    key
      .replace(/([A-Z])/g, " $1")
      .charAt(0)
      .toUpperCase() + key.slice(1)
  );
}
