export const formatMilliseconds = (ms) => {
  let d, h, m, s;
  s = Math.floor(ms / 1000);
  m = Math.floor(s / 60);
  s = s % 60;
  h = Math.floor(m / 60);
  m = m % 60;
  d = Math.floor(h / 24);
  h = h % 24;

  const pad = (n) => (n < 10 ? "0" + n : n);

  return d + "d " + pad(h) + "h " + pad(m) + "m";
};
