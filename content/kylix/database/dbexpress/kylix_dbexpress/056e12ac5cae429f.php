<h1>Kylix Tutorial. Часть 1. Установка</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Mike Goblin</div>

<p>  Итак, свершилось, проходя мимо ларька с CD я увидел компакт с этикеткой синего цвета и магической надписью Kylix. Вернее диска было два и оба были немедленно куплены.</p>
<p>  Беглое изучение их показало, что один содержит непосредственно Kylix, а второй дополнительные компоненты и утилиты третьих фирм и Interbase 6. По хорошей традиции пиратами была слита самая "продвинутая" версия Kylix Server Developer.</p>
<p>  Ставить Kylix я пробовал под RedHat Linux 7.0.</p>
<p>  Для установки нам потребуется</p>
<p>    а) Компьютер с установленной ОС Linux</p>
<p>    б) В составе Linux должны быть установлены графические оболочки GNOME и / или KDE (возможно Kylix будет работать и с другими, но эти две наиболее распространенны и Borland гарантирует работу под ними). Лично я пользуюсь KDE, посему про нее и буду рассказывать.</p>
<p>    в) Права пользователя root</p>

<p>  Первым делом необходимо установить патч на библиотеку glibc, по каким-то причинам не устроившую фирму Borland. Для этого и необходимо иметь права root. Заплатки (patches) сложены в директории /patches CD-ROM. Для Redhat 7.0 необходимо перейти в директорию &lt;путь к CD&gt;/patches/glibc_redhat/7.0. Установка патчей выполняется командами</p>
<p>    rpm -Uvh glibc-[2c]*</p>
<p>    rpm -Fvh glibc-[dp]* nscd-*</p>

<p>  Возможно также Вам придется установить пакет libjpeg либо из дистрибутива RedHat либо из папки &lt;путь к CD&gt;/patches/jpeg6.2.0</p>
<p>  Далее установка может проводиться как под аккаунтом root, так и под простым пользователем. Для инсталляции необходимо запустить на выполнение скрипт setup.sh. из корня CD.Графическая оболочка установки сделана удобно и интуитивно понятна. По умолчанию установка предлагается в домашнюю директорию пользователя, однако, чтобы при наличии нескольких пользователей лучше устанавливать в /usr/kylix, чтобы Kylix был доступен всем.</p>
<p>  После установки запуск IDE Kylix можно выполнить</p>
<p>    1) из командной строки: &lt;путь инсталляции&gt;/bin/startkylix</p>
<p>    2) из выпадающего меню KDE (аналог кнопки Пуск в Windows). Меню Borland Kylix/Kylix</p>
<p>    3) из выпадающего меню KDE (аналог кнопки Пуск в Windows). Меню /RedHat/ Borland Kylix/Kylix</p>

<p>Далее обнаруживается следующая неприятная вещь: в среде разработки программы компилируются и работают, однако при запуске вне IDE возникают ошибки. Лечится это так</p>
<p>  1. Прописать пути к библиотекам. В файле .bash_profile в строку PATH добавить путь к директории bin Kylix-а. Например, если он установлен в /usr/kylix - то добавить надо путь /usr/kylix/bin.</p>
<p>  2. В файл /etc/ld.so.conf добавить строчку с путем к libqtintf.so (в нашем примере /usr/kylix/bin)</p>
<p>  3. запустить ldconfig.</p>

<p>Взято с сайта <a href="https://www.delphimaster.ru/" target="_blank">https://www.delphimaster.ru/</a></p>

<p> с разрешения автора.</p>

