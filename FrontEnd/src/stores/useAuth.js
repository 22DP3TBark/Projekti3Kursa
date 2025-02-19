import router from "@/router";
import { ref } from "vue";
import axiosClient from "../../axiosClient";

const isAuthenticated = ref(!!localStorage.getItem("ACCESS_TOKEN"));

// Ensure localStorage.getItem("user") is valid JSON before parsing
const storedUser = localStorage.getItem("user");
const user = ref(storedUser ? safeParse(storedUser) : null);

function safeParse(jsonString) {
  try {
    return JSON.parse(jsonString);
  } catch (error) {
    console.error("Error parsing user data from localStorage:", error);
    return null;
  }
}

const login = (token, userData) => {
  localStorage.setItem("ACCESS_TOKEN", token);
  localStorage.setItem("user", JSON.stringify(userData));
  isAuthenticated.value = true;
  user.value = userData;
};

const logout = async () => {

  try {
    await axiosClient.post("/logout");
  } catch (error) {
    console.error("Error logging out:", error);
  }

  localStorage.removeItem("ACCESS_TOKEN");
  localStorage.removeItem("user");
  router.push("/login");
  isAuthenticated.value = false;
  user.value = null;

  router.push("/login");
};

const checkAuth = () => {
  isAuthenticated.value = !!localStorage.getItem("ACCESS_TOKEN");
  const storedUser = localStorage.getItem("user");
  user.value = storedUser ? safeParse(storedUser) : null;
};

export function useAuth() {
  return {
    isAuthenticated,
    user,
    login,
    logout,
    checkAuth,
  };
}
