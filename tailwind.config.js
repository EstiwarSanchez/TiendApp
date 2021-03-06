const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    mode: "jit",
    darkMode: "class",
    purge: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./public/js/nice-select.min.js",
    ],

    theme: {
        colors: {
            "psi-gray": "#706f6e",
            transparent: "transparent",
            white: "#ffffff",
            black: "#000000",
            gray: {
                50: "#f9fafb",
                100: "#f4f5f7",
                200: "#e5e7eb",
                300: "#d5d6d7",
                400: "#9e9e9e",
                500: "#707275",
                600: "#4c4f52",
                700: "#24262d",
                800: "#1a1c23",
                900: "#121317",
            },
            "cool-gray": {
                50: "#fbfdfe",
                100: "#f1f5f9",
                200: "#e2e8f0",
                300: "#cfd8e3",
                400: "#97a6ba",
                500: "#64748b",
                600: "#475569",
                700: "#364152",
                800: "#27303f",
                900: "#1a202e",
            },
            red: {
                50: "#fdf2f2",
                100: "#fde8e8",
                200: "#fbd5d5",
                300: "#f8b4b4",
                400: "#f98080",
                500: "#f05252",
                600: "#e02424",
                700: "#c81e1e",
                800: "#9b1c1c",
                900: "#771d1d",
            },
            orange: {
                50: "#fff8f1",
                100: "#feecdc",
                200: "#fcd9bd",
                300: "#fdba8c",
                400: "#ff8a4c",
                500: "#ff5a1f",
                600: "#d03801",
                700: "#b43403",
                800: "#8a2c0d",
                900: "#771d1d",
            },
            yellow: {
                50: "#fdfdea",
                100: "#fdf6b2",
                200: "#fce96a",
                300: "#faca15",
                400: "#e3a008",
                500: "#c27803",
                600: "#9f580a",
                700: "#8e4b10",
                800: "#723b13",
                900: "#633112",
            },
            green: {
                50: "#f3faf7",
                100: "#def7ec",
                200: "#bcf0da",
                300: "#84e1bc",
                400: "#31c48d",
                500: "#0e9f6e",
                600: "#057a55",
                700: "#046c4e",
                800: "#03543f",
                900: "#014737",
            },
            "psi-green": {
                50: "#D2EAB9",
                100: "#C9E6AA",
                200: "#BEE098",
                300: "#B1DA83",
                400: "#A0D269",
                500: "#8BC849",
                600: "#72BC23",
                700: "#5F9B1D",
                800: "#4E8018",
                900: "#416914",
            },
            "psi-blue": {
                50: "#B0E3F1",
                100: "#9FDDEF",
                200: "#8AD6EB",
                300: "#71CEE7",
                400: "#53C4E2",
                500: "#2FB7DC",
                600: "#03A8D5",
                700: "#038BB0",
                800: "#037391",
                900: "#035F78",
            },
            "psi-orange": {
                50: "#F5D6B1",
                100: "#F4D2A9",
                200: "#F2C896",
                300: "#F0BD81",
                400: "#ECAF66",
                500: "#E89E46",
                600: "#E4891F",
                700: "#BC7219",
                800: "#9B5F15",
                900: "#804E11",
            },
            teal: {
                50: "#edfafa",
                100: "#d5f5f6",
                200: "#afecef",
                300: "#7edce2",
                400: "#16bdca",
                500: "#0694a2",
                600: "#047481",
                700: "#036672",
                800: "#05505c",
                900: "#014451",
            },
            blue: {
                50: "#ebf5ff",
                100: "#e1effe",
                200: "#c3ddfd",
                300: "#a4cafe",
                400: "#76a9fa",
                500: "#3f83f8",
                600: "#1c64f2",
                700: "#1a56db",
                800: "#1e429f",
                900: "#233876",
            },
            indigo: {
                50: "#f0f5ff",
                100: "#e5edff",
                200: "#cddbfe",
                300: "#b4c6fc",
                400: "#8da2fb",
                500: "#6875f5",
                600: "#5850ec",
                700: "#5145cd",
                800: "#42389d",
                900: "#362f78",
            },
            purple: {
                50: "#f6f5ff",
                100: "#edebfe",
                200: "#dcd7fe",
                300: "#cabffd",
                400: "#ac94fa",
                500: "#9061f9",
                600: "#7e3af2",
                700: "#6c2bd9",
                800: "#5521b5",
                900: "#4a1d96",
            },
            pink: {
                50: "#fdf2f8",
                100: "#fce8f3",
                200: "#fad1e8",
                300: "#f8b4d9",
                400: "#f17eb8",
                500: "#e74694",
                600: "#d61f69",
                700: "#bf125d",
                800: "#99154b",
                900: "#751a3d",
            },
        },
        extend: {
            fontFamily: {
                sans: ["Inter", ...defaultTheme.fontFamily.sans],
            },
        },
    },
    variants: {
        extend: {
            textOpacity: ["dark", "active"],
            backgroundColor: ["dark", "active"],
            display: ["dark", "active"],
            textColor: ["dark", "active"],
            placeholderColor: ["dark", "active"],
            borderColor: ["dark", "active"],
            divideColor: ["dark", "active"],
            boxShadow: ["dark", "active"],
            opacity: ["disabled", "active"],
        },
    },

    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
    ],
};
