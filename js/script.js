"use strict";

document.addEventListener('DOMContentLoaded', function () {
  var app = new Vue({
    el: '#wrapper',
    data: {
      currentPage: 'startPage',
      registration: {
        // Account internal data
        number: '+7',
        inn: '',
        organisationName: '',
        organisationType: 'OOO',
        jurAddress_1: '',
        jurAddress_2: '',
        email: '',
        password: '',
        repeatPassword: '',
        array: {}
      },
      authorisation: {
        mail: '',
        pass: '',
        arr: {}
      },
      account: {
        // Account internal data
        accountPage: 'organisationData',
        companyData: {
          companyType: '',
          companyName: '',
          inn: '',
          number: '',
          mail: '',
          staff: '',
          jurAddress_1: '',
          jurAddress_2: ''
        },
        staffnameData: [// Staff array (normally empty)
        {
          name: 'Идрисов Руслан Алексеевич',
          passport: '9024242341'
        }, {
          name: 'Кадрисов Руслан Алексеевич',
          passport: '9024242341'
        }, {
          name: 'Барбарисов Руслан Алексеевич',
          passport: '9024242341'
        }]
      }
    },
    computed: {
      combineRegistrationForm: function combineRegistrationForm() {
        var _this$registration = this.registration,
            number = _this$registration.number,
            inn = _this$registration.inn,
            organisationName = _this$registration.organisationName,
            organisationType = _this$registration.organisationType,
            jurAddress_1 = _this$registration.jurAddress_1,
            jurAddress_2 = _this$registration.jurAddress_2,
            email = _this$registration.email,
            password = _this$registration.password;

        if (true) {// Validation here
        }

        this.registration.array = {
          // Create a registration form array
          number: number,
          inn: inn,
          organisationType: organisationName,
          organisationName: organisationType,
          jurAddress_1: jurAddress_1,
          jurAddress_2: jurAddress_2,
          mail: email,
          password: password
        };
      }
    },
    methods: {
      submit: function submit() {
        // Registration submit
        this.combineRegistrationForm;
        this.sendAjax();
      },
      auth: function auth() {
        var _this = this;

        this.authorisation.arr = {
          mail: this.authorisation.mail,
          pass: this.authorisation.pass
        };
        var authentificationArr = JSON.stringify(this.authorisation.arr);
        axios // Ajax authentification 
        .post('./form.php', authentificationArr).then(function (response) {
          console.log(response.data);

          if (response.data.organisationType) {
            //
            var _response$data = response.data,
                number = _response$data.number,
                inn = _response$data.inn,
                organisationType = _response$data.organisationType,
                organisationName = _response$data.organisationName,
                jurAddress_1 = _response$data.jurAddress_1,
                jurAddress_2 = _response$data.jurAddress_2,
                mail = _response$data.mail; // Set the local variables from server

            _this.account.companyData.companyType = organisationName;
            _this.account.companyData.companyName = organisationType;
            _this.account.companyData.inn = inn;
            _this.account.companyData.mail = mail;
            _this.account.companyData.number = number;
            _this.account.companyData.jurAddress_1 = jurAddress_1;
            _this.account.companyData.jurAddress_2 = jurAddress_2;
            _this.currentPage = 'account';
          }
        })["catch"](function (error) {
          return console.log(error);
        });
      },
      switchPage: function switchPage(arg) {
        this.currentPage = arg;
      },
      switchAccount: function switchAccount(arg) {
        this.account.accountPage = arg;
      },
      sendAjax: function sendAjax(url) {
        var jsonData = JSON.stringify(this.registration.array);
        axios // Ajax registration
        .post('./form.php', jsonData).then(function (response) {
          return console.log(response.data);
        })["catch"](function (error) {
          return console.log(error);
        });
      }
    }
  }); // Probably useles 

  window.addEventListener('scroll', function () {});
  window.addEventListener('click', function (e) {
    if (e.target) {} else {}
  });
});