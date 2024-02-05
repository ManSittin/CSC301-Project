import "./App.css"
import { BrowserRouter, Routes, Route } from "react-router-dom";
//import Layout from "./pages/Layout";
import TokenContext, { TokenProvider } from "./pages//TokenContext"
import Home from "./pages/Home.js";
import Signinup from "./pages/Signinup";
import SignUpDetails from "./pages/SignUpDetails";
import ProfilePage from "./pages/ProfilePage";

export default function App() {
  return (
    <TokenProvider>
    <BrowserRouter>
      <Routes>
      
          <Route path="/"  element={<Home />} />
          <Route path="Signinup" element={<Signinup/>} />
          <Route path="SignUpDetails" element={<SignUpDetails/>} />
          <Route path="ProfilePage" element={<ProfilePage/>} />
          <Route path="*" />
          

       


      </Routes>
    </BrowserRouter>

    </TokenProvider>
  );
}