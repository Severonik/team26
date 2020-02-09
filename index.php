<!DOCTYPE html>
<html lang="ru">
<?php Session_start(); ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="index">

    <noscript>Для отображения вам необходимо подключить JavaScript</noscript>
    <div id="wrapper">

        <!-- <nav>
            <div class="nav_test" @click="switchPage('startPage')">главная</div>
            <div class="nav_test" @click="switchPage('account')">личный кабинет</div>
        </nav> -->
        

        <!-- main -->
        <main v-if="currentPage !== 'account'">
            <div class="logotype">
                <img src="./images/icons/logo2.svg" alt="">
            </div>
            <img class="sun" src="./images/banners/sun.png" alt="">


            <!-- startPage -->
            <div v-if="currentPage === 'startPage'" class="startPage">
                <img class="startPage__cloud" src="./images/banners/obl.png" alt="">
                <img class="startPage__cloud" src="./images/banners/obl.png" alt="">

                <div class="startPage__buttons">
                    <div @click="switchPage('autorisationPage')">авторизация</div>
                    <div @click="switchPage('registrationPage')">регистрация</div>
                </div>
            </div>





            <!-- Registration page -->
            <div class="registrationPage" v-if="currentPage === 'registrationPage'">
                <form>
                    <div class="registrationPage__col_1">
                        <span>
                            <input v-model="registration.number" class="basic-slide" id="phone" type="text"
                                placeholder="+7 777 777 77 77" />
                            <label for="phone">Телефон:</label>
                        </span>

                        <span>
                            <input v-model="registration.inn" placeholder="0000000000" class="basic-slide" id="name"
                                type="text" />
                            <label for="name">ИНН:</label>
                        </span>

                        <div class="registrationPage__div_1">
                            <span>
                                <input v-model="registration.organisationName" placeholder="0000000000"
                                    class="basic-slide form__organisation" id="organisation" type="text" />
                                <label for="organisation">Организация:</label>
                            </span>
                            <select v-model="registration.organisationType">
                                <option disabled value="">Выберите один из вариантов</option>
                                <option>OOO</option>
                                <option>OAO</option>
                                <option>ИП</option>
                            </select>
                        </div>

                        <div class="registrationPage__div_2">
                            <span> 
                                <input id="jurAddress" v-model="registration.jurAddress_1" type="text"
                                    class="basic-slide" placeholder="">
                                <label for="jurAddress">Юр. Адрес:</label>
                            </span>
                            <input v-model="registration.jurAddress_2" placeholder="">
                        </div>
                    </div> 

                    <div class="registrationPage__col_2">
                        <span>
                            <input v-model="registration.email" placeholder="mail@mail.com" class="basic-slide"
                                id="email" type="text" />
                            <label for="email">Почта:</label>
                        </span>

                        <span>
                            <input v-model="registration.password" placeholder="Ваш пароль" type="password" class="basic-slide"
                                id="password" type="text" />
                            <label for="password">Пароль:</label>
                        </span>
                        <span>
                            <input type="password" v-model="registration.repeatPassword" placeholder="Повторите пароль"
                                class="basic-slide" id="repeatPassword" type="text" />
                            <label for="repeatPassword">Повторите пароль:</label>
                        </span>

                        <div class="registrationSubmit" @click={{submit()}}>Зарегистрироваться</div>

                    </div>
                </form>
            </div>


            <!-- Authorisation page -->
            <div class="authorisationPage" v-if="currentPage === 'autorisationPage'">
                <form>
                    <p>Ваша почта: </p>
                    <input v-model="authorisation.mail" placeholder="mail@mail.com">
                    <p>Пароль: </p>
                    <input v-model="authorisation.pass" placeholder="" type="password">
                    <div @click={{auth()}} class="authorisationSubmit">Войти</div>
                </form>
            </div>
        </main>



        <!-- Account -->
        <div v-else class="account">
            <header>
                <div class="left">
                    <img src="./images/icons/logo2.svg" alt="">
                </div>
                <div class="right">
                    <img src="./images/banners/белая звезда-min.png" alt="">
                </div>
            </header>

            <!-- Account left navigation -->
            <div class="account__body ">
                <nav>
                    <div @click="switchAccount('organisationData')">
                        <div>
                            <img src="./images/icons/данные организации.png" alt="">
                        </div>
                        <p>Данные организации</p>
                    </div>
                    <div @click="switchAccount('staff')">
                        <div>
                            <img src="./images/icons/сотрудники.png" alt="">
                        </div>
                        <p>Сотрудники</p>
                    </div>
                    <div @click="switchAccount('buyTickets')">
                        <div>
                            <img src="./images/icons/купить билеты.png" alt="">
                        </div>
                        <p>Купить билеты</p>
                    </div>
                    <div @click="switchAccount('buyHistory')">
                        <div>
                            <img src="./images/icons/история покупок.png" alt="">
                        </div>
                        <p>История покупок</p>
                    </div>
                    <div @click="switchPage('startPage')">
                        <div>
                            <img src="./images/icons/выход.png" alt="">
                        </div>
                        <p>Выход</p>
                    </div>
                </nav>

                <img src="./images/banners/серая звезда-min.png" alt="">

                <div v-if="account.accountPage === 'organisationData'" class="organisationData">
                    <div>
                        <div> 
                            <p class="companyType">{{ account.companyData.companyType }}</p>
                            <div class="companyName">{{account.companyData.companyName}}</div>
                        </div>
                        <div>
                            <p>ИНН</p> 
                            <p class="inn">{{ account.companyData.inn }}</p>
                        </div>
                        <div>
                            <p>Номер телефона</p> 
                            <p class="number">{{ account.companyData.number }}</p>
                        </div>
                        <div>
                            <p>Почта</p>
                            <p class="mail">{{ account.companyData.mail }}</p>
                        </div>
                        <div>
                            <p>Кол-во сотрудников</p> 
                            <p class="toStaff">{{ account.companyData.staff }}</p>
                        </div>
                    </div>
                </div>
                <div v-if="account.accountPage === 'staff'" class="staff">
                    <div class="search">
                        <div><img src="./images/icons/лупа.png" alt=""></div>
                        <input type="text">
                    </div>

                    <div class="staff__table">
                        <div class="th">
                            <div class="fio">ФИО</div>
                            <div class="passport">ПАСПОРТ</div>
                            <div class="options">.</div>
                        </div>
                        <div v-for="item in account.staffnameData" class="tr">
                            <div>{{item.name}}</div>     
                            <div>{{item.passport}}</div>
                        </div>
                    </div>
                </div>
                <div v-if="account.accountPage === 'buyTickets'" class="buyTickets">
                    <h2>Выбирите тариф</h2> 
                    <div class="buyTickets__nav">
                        <div @click="switchAccount('standart')">Стандарт</div>
                        <div @click="switchAccount('hereAndThere')">Туда-обратно</div>
                        <div @click="switchAccount('business')">Бизнес</div>
                    </div>
                    <div v-if="account.currentAccount === 'standart'" class="account__standart">
                        <div>
                            <p>Дата поездки: </p>
                            <input type="text">standart
                        </div> 
                    </div>
                    <div v-if="account.currentAccount === 'standart'" class="account__hereAndThere">
                        <div>
                            <p>Дата поездки: </p>
                            <input type="text">hereAndThere
                        </div> 
                    </div>
                    <div v-if="account.currentAccount === 'busines'" class="account__busines">
                            <p>Дата поездки: </p>
                            <input type="text">busines  
                    </div>
                </div>
                <div v-if="account.accountPage === 'buyHistory'" class="buyHistory">
                    buyHistor
                </div>
            </div>


        </div>


        <div class="train" v-if="currentPage !== 'account'">
            <img src="./images/banners/poezzzzzzzzzzd.png" alt="">
        </div>


    </div>
    <script src="./js/vue.js"></script>
    <script src="./js/script.js"></script>
</body>

</html>