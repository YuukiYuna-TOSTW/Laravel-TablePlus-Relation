module.exports = {
  plugins: {
    // Tailwind is handled by the @tailwindcss/vite plugin during the Vite build.
    // Avoid using `tailwindcss` directly here (Tailwind v4 expects a separate PostCSS plugin).
    autoprefixer: {},
  },
};
