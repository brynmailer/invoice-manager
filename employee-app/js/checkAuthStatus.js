export const checkAuthStatus = async () => {
  const res = await fetch("/api/auth/me", {
    method: "GET",
    mode: "same-origin",
    credentials: "include",
  });

  switch (res.status) {
    case 401:
      localStorage.removeItem("employee");
      return false;

    case 200:
      const data = await res.json();
      localStorage.setItem("employee", JSON.stringify(data.employee));
      return true;
  }
};
