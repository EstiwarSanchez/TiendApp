function data() {
    function getThemeFromLocalStorage() {
        // if user already changed the theme, use it
        if (window.localStorage.getItem("dark")) {
            return JSON.parse(window.localStorage.getItem("dark"));
        }

        // else return their preferences
        return (!!window.matchMedia &&
            window.matchMedia("(prefers-color-scheme: dark)").matches
        );
    }

    function setThemeToLocalStorage(value) {
        window.localStorage.setItem("dark", value);
    }

    function getMobile() {
        if (window.innerWidth > 920) {
            return false;
        }
        return true;
    }
    return {
        dsbld:false,
        mobile: getMobile(),
        setMobile() {
            this.mobile = getMobile();
        },
        dark: getThemeFromLocalStorage(),
        toggleTheme() {
            this.dark = !this.dark;
            setThemeToLocalStorage(this.dark);
        },
        isSideMenuOpen: false,
        toggleSideMenu() {
            this.isSideMenuOpen = !this.isSideMenuOpen;
        },
        closeSideMenu() {
            if (this.mobile) {
                this.isSideMenuOpen = false;
            }
        },
        isNotificationsMenuOpen: false,
        toggleNotificationsMenu() {
            this.isNotificationsMenuOpen = !this.isNotificationsMenuOpen;
        },
        closeNotificationsMenu() {
            var overlay = document.querySelector('.shepherd-modal-overlay-container');
            if (overlay && overlay.clientHeight<=0) {
                this.isNotificationsMenuOpen = false;
            }
        },
        isProfileMenuOpen: false,
        toggleProfileMenu() {
            this.isProfileMenuOpen = !this.isProfileMenuOpen;
        },
        closeProfileMenu() {
            var overlay = document.querySelector('.shepherd-modal-overlay-container');
            if (overlay && overlay.clientHeight<=0) {
                this.isProfileMenuOpen = false;
            }

        },
        isAlert: [false, false, false, false, false, false],
        showAlert(index) {
            this.isAlert[index] = true;
        },
        closeAlert(index) {
            this.isAlert[index] = false;
        },
        // Modal
        isModalOpen: false,
        trapCleanup: null,
        openModal() {
            this.isModalOpen = true;
            this.trapCleanup = focusTrap(document.querySelector("#modal"));
        },
        closeModal() {
            this.isModalOpen = false;
            this.trapCleanup();
        },
    };
}

window.hideModal = function(id) {
    var el = document.getElementById(id);
    if (el) {
        el.__x.$data.show = false
    }
}

window.showModal = function(id) {
    var el = document.getElementById(id);
    if (el) {
        el.__x.$data.show = true;
    }
}

function noticesHandler() {
    return {
        notices: [],
        visible: [],
        add(notice) {
            notice.id = Date.now()
            this.notices.push(notice)
            this.fire(notice.id)
        },
        fire(id) {
            this.visible.push(this.notices.find(notice => notice.id == id))
            const timeShown = 16500 * this.visible.length
            setTimeout(() => {
                this.remove(id)
            }, timeShown)
        },
        remove(id) {
            const notice = this.visible.find(notice => notice.id == id)
            const index = this.visible.indexOf(notice)
            this.visible.splice(index, 1)
        },

    };
}
