<h1>Защита данных</h1>
<div class="date">01.01.2007</div>


<p>Давайте принципиально различать 2 ситуации:</p>

<p>Ситуация I</p>
<p>Нужно чтобы программа где-то хранила свои данные в зашифрованном виде. Пользователь никаких паролей не вводит. Такой сценарий обычно нужен чтобы предупредить возможность пользователя напрямую манипулировать теми или иными данными, позволяя ему общение только через программу.</p>

<p>Для этого случая сила криптографических алгоритмов не принципиальна. Против ламера поможет любая защита, против хакера - никакая защита не сработает, так как пароль/ключ и алгоритм уже находятся в руках, всё зашито в базе данных, exe и т.п. у пользователя на компьютере, то так или иначе эта защита вскрывается - программа дизассемблируется, трассируется, запросы к базе перехватываются и т.д. В данном случае что Парадокс, что MS Access, что любая другая база данных - не имеет значения, вопрос в том сломают её за 5 минут или за час.</p>

<p>Ситуация II</p>
<p>Есть конфиденциальные данные конкретного пользователя. Чтобы получить свои данные пользователь должен руками ввести свой пароль. Сам пароль известен только пользователю, ни в програмном коде, ни в базе данных он нигде не хранится.</p>

<p>Вот здесь надо обратить внимание на базу данных. Сразу скажу - базы данных типа Парадокс, Foxpro, MS Access - подходят только если использовать шифрование данных, надеятся на их встроенные системы защиты нельзя. Лучше всего защищены промышленные сервера, типа MS SQL Server, Oracle, DB/2, SyBase. И тем ни менее, даже при их использовании, для максимальной защиты лучше шифровать вносимые данные по какому-нибудь криптостойкому алгоритму, например:</p>

<p>берётся строка: "Логин+Пароль", введенные пользователем </p>
<p>на этой строке делается MD5 - получается 32 битный ключ</p>
<p>Все данные читаются и пишутся с предварительной шифровкой/дешифровкой с полученным ключём использую алгоритм "трипл-дес"</p>

<p>При таком раскладе можно и в парадоксе хранить - расшифровать практически невозможно. Только надо понимать что при таком алгоритме нет никакой возможности восстановить утерянный пароль, обнулить пароль и восстановить инфу при потере логина или пароля - информация будет утеряна навсегда.</p>

<p>Рассмотренные сценарии относятся к случаю, когда база данных поставляется с программой, если используется удалённый сервер баз данных или например для web приложений, то там правила немного другие, надо принимать в рассчёт многочисленные возможности защиты информации на удалённом компьютере. </p>
<div class="author">Автор: Vit</div>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

