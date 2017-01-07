export default {
    checkAuth: function (vm) {
        if (localStorage.getItem('access_token') !== null) {
            vm.$http.get(window.api + '/user').then((response) => {
                if (response.data.status == 'success') {
                    vm.user = response.data.user;
                }
            }).catch((response) => {
                localStorage.removeItem('access_token');

                vm.user = null;
            });
        }
    },
    logout: function (vm, router) {
        vm.$http.post(window.api + '/auth/logout', {}).then((response) => {
            if (response.data.status == 'success') {
                localStorage.removeItem('access_token');

                vm.user = null;

                router.push({ name: 'doodles' });
            }
        });
    }
}
