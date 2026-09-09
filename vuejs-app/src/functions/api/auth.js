import axios from "axios";

const APP_API_URL= import.meta.env.VITE_APP_API_URL;

export async function apiSignup(user) {
    return await axios.post(APP_API_URL+"/signup",user);
}
export async function apiSignin(user) {
    return await axios.post(APP_API_URL+"/signin",user);
}
export async function apiSignout(token) {
    return await axios.post(APP_API_URL+"/signout",null,{
        headers:{
            Authorization:`Bearer ${token}`
        }
    });
}
export async function apiVerify(token) {
    return await axios.get(APP_API_URL+"/verify",{
        headers:{
            Authorization: `Bearer ${token}`,
        }
    });
}