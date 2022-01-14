angular.module('app').controller('ProfileCtrl', ProfileCtrl);
ProfileCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector'];

function ProfileCtrl($scope, $ocLazyLoad, $injector) {
    var vm = this;
    vm.changeBox = 'Username';
    vm.changeImage = false;
    vm.password = {};
    vm.username = {};
    vm.profile = {};
    vm.profile.ProfilePic = 'assets/images/default.jpg';
    $ocLazyLoad.load([
        APPURL + 'app.service.js?v=' + VERSION,
    ]).then(function (d) {
        AppSvc = $injector.get('AppSvc');
        vm.getUserCredentials();
    });
    vm.getUserCredentials = function () {
        LOADING.classList.add("open");
        AppSvc.get().then(function (response) {
            if (response) {
                vm.credentials = response.record;
                vm.profile.ProfilePic = response.record.pic ? response.record.pic : 'assets/images/default.jpg';
            }
            LOADING.classList.remove("open");
        });
    };
    vm.changingBox = function (type) {
        var currentBox = vm.changeBox;
        vm.changeBox = currentBox === type ? '' : type;
    }
    vm.Preview = function () {
        vm.changeImage = true;
        var file = document.getElementById('file').files[0],
            r = new FileReader();
        r.onload = function (e) {
            document.getElementById('img').src = 'data:image/jpeg;base64,' + btoa(e.target.result);
            document.getElementById('img-top').src = 'data:image/jpeg;base64,' + btoa(e.target.result);
        };
        r.readAsBinaryString(file);
    };
    vm.changePic = function () {
        var file = document.getElementById('file');
        file.click();
    }
    vm.saveUsername = function () {
        LOADING.classList.add('open');
        var data = angular.copy(vm.username);
        data.edit = true;
        AppSvc.save(data).then(function (response) {
            if (response.success) {
                AppSvc.showSwal('Success', response.message, 'success');
            } else {
                if (response.username) {
                    AppSvc.showSwal('Ooops', "This username was already in the record! Please try another username. Thank you.", 'danger');
                } else if (response.password) {
                    AppSvc.showSwal('Ooops', "You inputted wrong password! Please try again.", 'danger');
                } else {
                    AppSvc.showSwal('Ooops', 'Nothing Changed. Failed Saving.', 'warning');
                }

            }
            LOADING.classList.remove('open');
        });
    };
    vm.savePassword = function () {
        if (vm.password.RetypePassword !== vm.password.NewPassword) {
            return AppSvc.showSwal(
                'Ooops',
                'New Password does not match to Retype Password. Try Again',
                'warning'
            );
        }
        LOADING.classList.add('open');
        var data = angular.copy(vm.password);
        data.changePass = true;
        AppSvc.save(data).then(function (response) {
            if (response.success) {
                AppSvc.showSwal('Success', response.message, 'success');
            } else {
                if (response.password) {
                    AppSvc.showSwal('Ooops', "You're old password is incorrect! Please try again.", 'danger');
                } else {
                    AppSvc.showSwal('Ooops', 'Nothing Changed. Failed Saving.', 'warning');
                }

            }
            LOADING.classList.remove('open');
        });
    };
    vm.saveProfPic = function () {
        var newData = new FormData();
        newData.append('description', vm.profile.description);
        newData.append('file_id', vm.profile.file_id);
        newData.append('file', vm.profile.file);
        newData.append('date', AppSvc.getDate(vm.profile.date));
        newData.append('Password', vm.profile.Password);
        newData.append('ProfilePic', vm.profile.ProfilePic);
        newData.append('changePic', true);
        if (vm.changeImage) {
            newData.append('image', vm.image);
        }
        LOADING.classList.add('open');
        AppSvc.upload(newData).then(function (response) {
            if (response.success) {
                AppSvc.showSwal('Success', response.message, 'success');
            } else {
                if (response.password) {
                    AppSvc.showSwal('Ooops', "You inputted wrong password! Please try again.", 'danger');
                } else {
                    AppSvc.showSwal('Ooops', 'Nothing Changed. Failed Saving.', 'warning');
                }
            }
            LOADING.classList.remove('open');
        });
    }
}