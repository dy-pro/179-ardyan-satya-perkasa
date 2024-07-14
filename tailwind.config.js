/** @type {import('tailwindcss').Config} */
export default {
  purge: {
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
      "./node_modules/flowbite/**/*.js"
    ],
    options: {
      safelist: [
        'bg-yellow-100', 'text-yellow-800',
        'bg-green-100', 'text-green-800',
        'bg-red-100', 'text-red-800'
      ],
    },
  },
  theme: {
    extend: {},
    fontFamily: {
      'omegle': 'omegle',
      'metropolis': 'metropolis',
    },
  },
  plugins: [
    // require('flowbite/plugin')({
    //   charts: true,
    // }),
    require('daisyui')
  ],
  daisyui: {
    themes: [
      {
        light: {
          ...require("daisyui/src/theming/themes")["light"],
          "primary": "#32E0C4",
          "secondary": "#9BCDD2",
          "accent" : "#FAF0E4",
          "neutral": "#FFFFFF",
          "base-100": "#E7EBEB",

          "--neutral-80": "#ffffff80",
          "--drop-shadow": "#C5C5C5",
          "--inset-shadow": "#8F9B9B",
          "--neu-border": "#e8e8e8",
          
        },
        dark: {
          ...require("daisyui/src/theming/themes")["dark"],
          "primary": "#76ABAE",
          "secondary": "#31363F",
          "base-100": "#222831",
          "neutral": "#2b313d",
          "--neutral-80": "#2b313d80",
          "--neu-border": "#22283",
          "--drop-shadow": "#212121",
          "--inset-shadow": "#212121",
        },
      },
    ],
  }
}

