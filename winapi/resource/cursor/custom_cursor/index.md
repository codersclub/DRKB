---
Title: Как использовать свои курсоры?
Date: 01.01.2007
---

Как использовать свои курсоры?
==============================

Вариант 1:

Source: <https://blackman.wp-club.net/>

    {$R CURSORS.RES}
     
    const
      crZoomIn = 1; 
      crZoomOut = 2; 
     
    Screen.Cursors[crZoomIn] := LoadCursor(hInstance, 'CURSOR_ZOOMIN');
    Screen.Cursors[crZoomOut] := LoadCursor(hInstance, 'CURSOR_ZOOMOUT'); 

С вашей программой должен быть слинкован файл ресурсов, содержащий
соответствующие курсоры или заменить зеленое на конкретное имя файла(он
должен также поставляться с программой).


------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

В этой статье вы найдёте несколько способов использования собственных
курсоров, в том числе и анимированных. [это файлы с расширением .ani]

Например, у вас есть какой-то файл с расширением .ani и вы хотите его
задействовать. Всё, что вам для этого потребуется сделать, это -
поместить файл в тот же каталог, где будет ваш exe, а затем написать
следующий код, ну, скажем, по нажатию на кнопку:

    Screen.Cursors[5] := LoadCursorFromFile('File.ani');
    Screen.Cursor := 5;

Здесь используется свойство Cursors глобального объекта Screen. В нём
содержится список курсоров, доступных приложению. По индексу в нужную
позицию мы загружаем курсор из файла. А затем с помощью свойства Cursor
задействуем его.

Если же вы имеете файл ресурсов, тогда дела будут обстоять иначе:

Помещаете этот файл в тот же каталог, что и exe. Затем в модуле
объявляем глобальную константу, например после

    var
      Form1: TForm1;

Выглядеть это будет примерно так:

    var
      Form1: TForm1;
    const
      MyConst = 100;

С помощью этой константы мы зарезервируем новую позицию в свойстве
Cursors глобального объекта Screen.

После чего подключаем файл ресурсов, т.е. если он у нас называется
Cursors.res, тогда после

    {$R *.DFM}
    {$R Cursors.res}
    ...
     
    //Затем, допустим, по нажатию на кнопку пишем код: 
     
    Screen.Cursors[MyConst] := LoadCursor(hInstance,'MYCURSOR');
    Screen.Cursor := MyConst;

Здесь \'MYCURSOR\' - это имя курсора, который нам необходимо загрузить.
Обратите внимание, если вы создаёте файл ресурсов самостоятельно, а
сделать это можно с помощью утилиты "ImageEditor", вам необходимо в
именах курсоров использовать только прописные буквы.


