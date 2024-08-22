function data() {
    function getThemeFromLocalStorage() {
        // if user already changed the theme, use it
        if (window.localStorage.getItem("dark")) {
            return JSON.parse(window.localStorage.getItem("dark"));
        }

        // else return their preferences
        return (
            !!window.matchMedia &&
            window.matchMedia("(prefers-color-scheme: dark)").matches
        );
    }

    function setThemeToLocalStorage(value) {
        window.localStorage.setItem("dark", value);
    }

    return {
        // sidebar
        isSideMenuOpen: false,
        toggleSideMenu() {
            this.isSideMenuOpen = !this.isSideMenuOpen;
        },
        closeSideMenu() {
            this.isSideMenuOpen = false;
        },

        // profil
        isProfileMenuOpen: false,
        toggleProfileMenu() {
            this.isProfileMenuOpen = !this.isProfileMenuOpen;
        },
        closeProfileMenu() {
            this.isProfileMenuOpen = false;
        },

        isPagesMenuOpen: false,
        togglePagesMenu() {
            this.isPagesMenuOpen = !this.isPagesMenuOpen;
        },

        // Modal
        isModalOpen: false,
        isModalCommentOpen: false,
        trapCleanup: null,
        openModal(id, name) {
            this.isModalOpen = true;
            this.dataId = id;
            this.dataName = name;
            this.trapCleanup = focusTrap(document.querySelector("#modal"));
        },
        openModalComment(id) {
            this.isModalCommentOpen = true;
            this.dataId = id;
            this.trapCleanup = focusTrap(
                document.querySelector("#commentmodal")
            );
        },
        submitForm() {
            // Close the modal
            this.closeModal();

            // Submit the form
            this.$refs.form.submit();
        },
        closeModal() {
            this.isModalOpen = false;
            this.isModalCommentOpen = false;
            this.trapCleanup();
        },
    };
}
