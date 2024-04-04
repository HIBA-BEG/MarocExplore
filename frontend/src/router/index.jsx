import { createBrowserRouter } from "react-router-dom";

import Home from "../pages/Home.jsx";
import Login from "../pages/Login.jsx";
import Register from "../pages/Register.jsx";
import Users from "../pages/Users.jsx";
import NotFound from "../pages/NotFound.jsx";
import Layout from "../layouts/Layout.jsx";

export const router = createBrowserRouter([
    {
        element: <Layout />,
        children: [
            {
                path: "/",
                element: <Home />,
            },
            {
                path: "/login",
                element: <Login />,
            },
            {
                path: "/register",
                element: <Register />,
            },
            {
                path: "/users",
                element: <Users />,
            },
            {
                path: "*",
                element: <NotFound />,
            },
        ],
    },
]);

// import { createBrowserRouter } from "react-router-dom";

// export const router : Router = createBrowserRouter(routes: [
//     {
//         path: '/',
//         element: '<p>Hi from homePage</p>'
//     },
//     {
//         path: '/login',
//         element: '<p>Hi from login</p>'
//     },
//     {
//         path: '/register',
//         element: '<p>Hi from register</p>'
//     },
//     {
//         path: '/users',
//         element: '<p>Hi from users</p>'
//     },

// ])
