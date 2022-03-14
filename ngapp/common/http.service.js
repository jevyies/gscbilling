(function() {
    'use strict';
    angular
        .module('sharedMod', ['oc.lazyLoad'])
        .factory('httpService', httpService)
        .factory('baseService', baseService);

    httpService.$inject = ['$http', '$q', '$httpParamSerializerJQLike', '$ocLazyLoad', '$uibModal'];
    baseService.$inject = ['httpService', '$q', '$ocLazyLoad', '$uibModal', '$filter', 'toastr'];

    function httpService($http, $q, $httpParamSerializerJQLike, $ocLazyLoad, $uibModal) {
        var baseURL = '';
        var service = {
            getData: getData,
            postData: postData,
            putData: putData,
            deleteData: deleteData,
            uploadData: uploadData,
        };
        return service;

        function getData(data, urldata) {
            var url = this.baseURL;
            if (urldata) {
                url = urldata;
            }
            if (data && data != {}) {
                var params = '?';
                angular.forEach(data, function(v, k) {
                    params += k + '=' + v + '&';
                });
                url += params;
            }
            return $http({
                method: 'GET',
                url: url,
            }).then(
                function(results) {
                    return results;
                },
                function(error) {
                    if (error.status == 403) {
                        swal('You are not logged in. Please login again.', '', 'error');
                        window.location.href = BASE_URL + 'auth/login';
                    }
                }
            );
        }

        function postData(data) {
            return $http({
                method: 'POST',
                url: this.baseURL,
                headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
                data: $.param(data), //$httpParamSerializerJQLike(data)
            }).then(
                function(response) {
                    return response;
                },
                function(error) {
                    swal(error.data.message, '', 'warning');
                    return false;
                }
            );
        }

        function putData(data) {
            return $http({
                method: 'PUT',
                url: this.baseURL,
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                data: $.param(data),
            }).then(
                function(response) {
                    return response;
                },
                function(error) {
                    swal(error.data.message, '', 'warning');
                    return false;
                }
            );
        }

        function deleteData() {
            var baseURL = this.baseURL;
            var deferred = $q.defer();
            var templateUrl = COMURL + 'confirmation/view.html?v=' + VERSION;
            var filesToLoad = [
                COMURL + 'confirmation/view.html?v=' + VERSION,
                COMURL + 'confirmation/controller.js?v=' + VERSION,
            ]
            var controllerName = 'ConfirmationCtrl';
            var dataFromMainCtrl = {
                title: 'Confirm Deletion?',
                message: 'Are you sure you want to delete this record?',
                buttonTruthyName: 'Delete',
                buttonFalsyName: 'Cancel',
                danger: true
            };
            $ocLazyLoad.load(filesToLoad).then(function() {
                var modalInstance = $uibModal.open({
                    animation: false,
                    templateUrl: templateUrl,
                    controller: controllerName,
                    controllerAs: 'modal',
                    windowClass: 'confirmation-window',
                    backdrop: 'static',
                    resolve: {
                        data: function() {
                            return dataFromMainCtrl;
                        },
                    },
                });
                modalInstance.result.then(
                    function(data) {
                        if (data) {
                            LOADING.classList.add("open");
                            return $http({
                                method: 'DELETE',
                                url: baseURL,
                                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                            }).then(
                                function(results) {
                                    deferred.resolve(results);
                                },
                                function(error) {
                                    deferred.resolve(false);
                                }
                            );
                        }
                    },
                    function() {
                        console.log('Modal closed');
                    }
                );
            });
            return deferred.promise;
        }

        function uploadData(data) {
            return $http({
                method: 'POST',
                url: this.baseURL,
                withCredentials: true,
                headers: { 'Content-Type': undefined },
                transformRequest: angular.identity,
                data: data,
            }).then(
                function(results) {
                    return results;
                },
                function(error) {
                    swal(error.data.message, '', 'warning');
                    return false;
                }
            );
        }
    }

    function baseService(httpService, $q, $ocLazyLoad, $uibModal, $filter, toastr) {
        var baseService = function() {
            var service = {
                modal: modal,
                get: get,
                save: save,
                delete: remove,
                showSwal: showSweetAlert,
                http: angular.copy(httpService),
                records: [],
                upload: upload,
                has_get: false,
                getDate: getDate,
                getAmount: getAmount,
                getTime: getTime,
                parseTime: parseTime,
                confirmation: confirmation,
                pad: pad,
                autocomplete: autocomplete
            };

            return service;

            function modal(options) {
                var templateUrl = options.templateUrl;
                var filesToLoad = options.filesToLoad;
                var controllerName = options.controllerName;
                var viewSize = 'lg';
                if (options.viewSize && options.viewSize.length > 0) {
                    viewSize = options.viewSize;
                }
                var dataFromMainCtrl = options.data;
                var animation = options.animation ? true : false;
                var windowClass = options.windowClass;
                return $ocLazyLoad.load(filesToLoad).then(function() {
                    var modalInstance = $uibModal.open({
                        animation: animation,
                        templateUrl: templateUrl,
                        controller: controllerName,
                        controllerAs: 'modal',
                        size: viewSize,
                        backdrop: false,
                        windowClass: windowClass,
                        resolve: {
                            data: function() {
                                return dataFromMainCtrl;
                            },
                        },
                    });
                    return modalInstance.result.then(
                        function(data) {
                            return data;
                        },
                        function() {
                            console.log('Modal Closed');
                        }
                    );
                });
            }

            function confirmation(title, message, trueButton, falseButton, danger) {
                var data = { title: title, message: message, buttonTruthyName: trueButton, buttonFalsyName: falseButton, danger: danger };
                var templateUrl = COMURL + 'confirmation/view.html?v=' + VERSION;
                var filesToLoad = [
                    COMURL + 'confirmation/view.html?v=' + VERSION,
                    COMURL + 'confirmation/controller.js?v=' + VERSION,
                ]
                var controllerName = 'ConfirmationCtrl';
                return $ocLazyLoad.load(filesToLoad).then(function() {
                    var modalInstance = $uibModal.open({
                        animation: false,
                        templateUrl: templateUrl,
                        controller: controllerName,
                        controllerAs: 'modal',
                        windowClass: 'confirmation-window',
                        backdrop: 'static',
                        resolve: {
                            data: function() {
                                return data;
                            },
                        },
                    });
                    return modalInstance.result.then(
                        function(data) {
                            return data;
                        },
                        function() {
                            console.log('Modal Closed');
                        }
                    );
                });
            }

            function showSweetAlert(title, message, icon) {
                if (icon === 'success') {
                    toastr.success(message, title);
                } else if (icon === 'warning') {
                    toastr.warning(message, title);
                } else {
                    toastr.error(message, title);
                }
            }

            function getAmount(amount) {
                if (amount) {
                    var dt = amount.replace(/,/g, '');
                    return dt;
                }
            }

            function getDate(inputDate) {
                var dt = new Date(inputDate);
                var dtString = dt.getFullYear() + '-' + pad(dt.getMonth() + 1, 2) + '-' + pad(dt.getDate(), 2);
                return dtString;
            }

            function getTime(inputTime) {
                var dt = new Date(inputTime);
                var dtString = dt.getHours() + ':' + dt.getMinutes();
                return dtString;
            }

            function parseTime(inputTime) {
                var dates = new Date().getDate();
                var year = new Date().getFullYear();
                var month = new Date().getMonth();
                var splitTime = inputTime.split(':');
                var hours = splitTime[0];
                var minutes = splitTime[1];
                var timeString = new Date(year, month, dates, hours, minutes);
                return timeString;
            }

            function pad(number, length) {
                var str = '' + number;
                while (str.length < length) {
                    str = '0' + str;
                }
                return str;
            }

            function get(data) {
                httpService.baseURL = this.url;
                return httpService.getData(data).then(function(response) {
                    return response.data;
                });
            }

            function save(data) {
                httpService.baseURL = this.url;
                return httpService.postData(data).then(function(response) {
                    return response.data;
                });
            }

            function upload(data) {
                httpService.baseURL = this.url;
                return httpService.uploadData(data).then(function(response) {
                    return response.data;
                })
            }

            function remove(id) {
                httpService.baseURL = this.url + '?id=' + id;
                return httpService.deleteData().then(function(response) {
                    return response.data;
                });
            }
            function autocomplete(inp, arr) {
                /*the autocomplete function takes two arguments,
                the text field element and an array of possible autocompleted values:*/
                var currentFocus;
                /*execute a function when someone writes in the text field:*/
                inp.addEventListener("input", function(e) {
                    var a, b, i, val = this.value;
                    /*close any already open lists of autocompleted values*/
                    closeAllLists();
                    if (!val) { return false;}
                    currentFocus = -1;
                    /*create a DIV element that will contain the items (values):*/
                    a = document.createElement("DIV");
                    a.setAttribute("id", this.id + "autocomplete-list");
                    a.setAttribute("class", "autocomplete-items");
                    /*append the DIV element as a child of the autocomplete container:*/
                    this.parentNode.appendChild(a);
                    /*for each item in the array...*/
                    for (i = 0; i < arr.length; i++) {
                      /*check if the item starts with the same letters as the text field value:*/
                      if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                        /*create a DIV element for each matching element:*/
                        b = document.createElement("DIV");
                        /*make the matching letters bold:*/
                        b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                        b.innerHTML += arr[i].substr(val.length);
                        /*insert a input field that will hold the current array item's value:*/
                        b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                        /*execute a function when someone clicks on the item value (DIV element):*/
                        b.addEventListener("click", function(e) {
                            /*insert the value for the autocomplete text field:*/
                            inp.value = this.getElementsByTagName("input")[0].value;
                            /*close the list of autocompleted values,
                            (or any other open lists of autocompleted values:*/
                            closeAllLists();
                        });
                        a.appendChild(b);
                      }
                    }
                });
                /*execute a function presses a key on the keyboard:*/
                inp.addEventListener("keydown", function(e) {
                    var x = document.getElementById(this.id + "autocomplete-list");
                    if (x) x = x.getElementsByTagName("div");
                    if (e.keyCode == 40) {
                      /*If the arrow DOWN key is pressed,
                      increase the currentFocus variable:*/
                      currentFocus++;
                      /*and and make the current item more visible:*/
                      addActive(x);
                    } else if (e.keyCode == 38) { //up
                      /*If the arrow UP key is pressed,
                      decrease the currentFocus variable:*/
                      currentFocus--;
                      /*and and make the current item more visible:*/
                      addActive(x);
                    } else if (e.keyCode == 13) {
                      /*If the ENTER key is pressed, prevent the form from being submitted,*/
                      e.preventDefault();
                      if (currentFocus > -1) {
                        /*and simulate a click on the "active" item:*/
                        if (x) x[currentFocus].click();
                      }
                    }
                });
                function addActive(x) {
                  /*a function to classify an item as "active":*/
                  if (!x) return false;
                  /*start by removing the "active" class on all items:*/
                  removeActive(x);
                  if (currentFocus >= x.length) currentFocus = 0;
                  if (currentFocus < 0) currentFocus = (x.length - 1);
                  /*add class "autocomplete-active":*/
                  x[currentFocus].classList.add("autocomplete-active");
                }
                function removeActive(x) {
                  /*a function to remove the "active" class from all autocomplete items:*/
                  for (var i = 0; i < x.length; i++) {
                    x[i].classList.remove("autocomplete-active");
                  }
                }
                function closeAllLists(elmnt) {
                  /*close all autocomplete lists in the document,
                  except the one passed as an argument:*/
                  var x = document.getElementsByClassName("autocomplete-items");
                  for (var i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != inp) {
                      x[i].parentNode.removeChild(x[i]);
                    }
                  }
                }
                /*execute a function when someone clicks in the document:*/
                document.addEventListener("click", function (e) {
                    closeAllLists(e.target);
                });
            }
        };
        return baseService;
    }
})();