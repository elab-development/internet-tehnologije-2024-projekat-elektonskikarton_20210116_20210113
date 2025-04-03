/* eslint-disable no-unused-vars */
import React, { useEffect, useState } from 'react';
import axios from 'axios';
import Slider from 'react-slick';

import "slick-carousel/slick/slick.css"; 
import "slick-carousel/slick/slick-theme.css"; 


const ArticleCards = () => {
  const [articles, setArticles] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  // Funkcija za povlačenje podataka sa API-a
  useEffect(() => {
    axios.get('https://doaj.org/api/v2/search/articles/medicine')
      .then(response => {
        setArticles(response.data.results);  
        setLoading(false);
      })
      .catch(error => {
        setError('Došlo je do greške prilikom povlačenja podataka');
        setLoading(false);
      });
  }, []);

  if (loading) return <div>Loading...</div>; 
  if (error) return <div>{error}</div>; 

  // Slick settings for carousel
  const settings = {
    infinite: true,
    speed: 500,
    slidesToShow: 3,  // Broj kartica koje se prikazuju u jednom redu
    slidesToScroll: 1,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 2,
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 1,
        }
      }
    ]
  };

  return (
    <div className="article-cards-container text-center">
        <h2 className="title pt-3 pb-3">Zanimljivi časopisi u oblasti medicine</h2>
      <Slider {...settings}>
        {articles.map((article, index) => (
          <div key={index} className="article-card">
            <h3>{article.bibjson.journal.publisher}</h3>
            <p>{article.bibjson.year}</p>
            <p>{article.bibjson.author[0].name}</p>
            <a href={article.bibjson.link[0].url} target="_blank" rel="noopener noreferrer">
              Read more
            </a>
          </div>
        ))}
      </Slider>
    </div>
  );
};

export default ArticleCards;
