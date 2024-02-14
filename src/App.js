import "./App.css"
import { BrowserRouter, Routes, Route } from "react-router-dom";
import React from 'react';
//import Layout from "./pages/Layout";
import TokenContext, { TokenProvider } from "./pages//TokenContext"
import Home from "./pages/Home.js";
import Signinup from "./pages/Signinup.js";
import SignUpDetails from "./pages/SignUpDetails";
import ProfilePage from "./pages/ProfilePage.js";
import ContentNotes from "./pages/Content_notes";


export default function App() {

  return (
    <TokenProvider>
    <BrowserRouter>
      <Routes>
      
          <Route path="/"  element={<Home />} />
          <Route path="Signinup" element={<Signinup/>} />
          <Route path="Notes" element={ <ContentNotes/>} />
          <Route path="ProfilePage" element={<ProfilePage/>} />
          <Route path="*" />
          

       


      </Routes>
    </BrowserRouter>

    </TokenProvider>
  );
}