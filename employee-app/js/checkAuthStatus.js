export const checkAuthStatus = async () => {
  const authStatusRes = await fetch("/api/auth/status", {
    method: "GET",
    mode: "same-origin",
    credentials: "include",
  });

  switch (authStatusRes.status) {
    case 401:
      return false;
    case 200:
      return true;
  }
};
