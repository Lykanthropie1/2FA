# CS-CART 2FA module 

<details>
	<summary><b>Системные требования</b></summary>
    - ОС  Windows 10
    - Версия php 7.1
    - OpenServer 5.3.7
    - MySQL
    - CS-Cart 4.14.1 SP1
</details>

<details>
	<summary><b>Как развернуть приложение</b></summary><br>
+ Скопировать содержимое аддона в корневую папку магазина с заменой

</details>

<details>
	<summary><b>Как протестировать приложение</b></summary><br>

1. Начало авторизации
    + Заполнить данные для входа через popup или из формы авторизации;
    + Кликнуть по кнопке "Войти".<br>


<b>Ожидаемый результат:<b><br>
Произойдет перенаправление на страницу ввода секретного кода.


2. Верификация кода
    + Залогиниться (см. пункт 1);
    + На почту клиента должен придти 5-значный пароль для входа;
    + Ввести пароль.<br>

<b>Ожидаемый результат:<b><br>
Авторизация пройдет успешно.


3. Сброс пароля
    + Залогиниться (см. пункт 1);
    + На странице ввода пароля нажать кнопку "Изменить".<br>

<b>Ожидаемый результат:<b><br>
На почте должен появиться новый секретный код.
</details>
