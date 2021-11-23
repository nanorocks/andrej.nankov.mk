import { useState, useEffect, history } from "react";
import { read } from "../services/apiReader";


export default function useFetchListHook(url) {
  const [links, setLinks] = useState([]); 
  const [items, setItems] = useState([]);
  const [spinner, setSpinner] = useState(false);
  const [query, setQuery] = useState("&");

  const loadItems = () => {
    
    setSpinner(true);
    read(url, query)
      .then((result) => {
        setItems(result.data.data);
        setLinks(result.data.links);
        setSpinner(false);
      })
      .catch((error) => {
        console.log(error);
        history.push("/500");
      });
  };

  useEffect(() => {
    loadItems();
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [query]);

  const paginationLabelName = (label) => {
    if (label === "pagination.previous") {
      return "Previous";
    } else if (label === "pagination.next") {
      return "Next";
    }

    return label;
  };

  const loadNewItems = (url) => {
    setSpinner(true);

    let urlParams = new URL(url);
    let page = urlParams.searchParams.get("page");

    setQuery("&page=" + page);

    setTimeout(() => {
      setSpinner(false);
    }, 1000);
  };

  return [{ links, items, spinner }, paginationLabelName, loadNewItems];
};
