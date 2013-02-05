---
Title: Исследование E-Book Html Compiler 2.12
Author: Wersion
Date: 01.01.2007
---


Исследование E-Book Html Compiler 2.12
======================================

::: {.date}
01.01.2007
:::

Автор: Wersion

WEB сайт: http://expwinprg.cjb.net/

Итак, как это было.

Достались мне замечательные туторы Iczelion\'а по ассемблеру на русском
и английском языках. Перевод был сделан немного в стиле Promt\'а: с
падежами, окончаниями и т.д. всё в порядке, а до смысла докопаться
трудно. Я решил всё переделать и представить в культурном виде -- в
\'Single Exe\' как обещают создатели E-Book Html Compiler 2.12.
\<-Закачал его с http://new-projects.com/booksoft/ (не ошибитесь
версией) и запустил.

Что мы видим:

функциональные ограничения (Нет вкладки Security вообще)

Nag в производимом файле

Нехорошо. Начнём.

Что нужно: Tools (много):

ResHacker/Restorator/Exescope -- обязательно

Windows Commander 32 -- обязательно

UPX 1.07w -- обязательно

HIEW 6.11 -- обязательно (Ну куда же нам без него!)

Turbo Pascal for Windows 7.1 -- Recommended

Ida Pro -- optional

TRW 2000 -- optional

Any File Analyzer -- optional

Procdump32 - optional

The Customiser - Recommended

W32Dasm -- optional

Brains: Среднее количество\[x\]

Исследование

Посмотрим Help. Есть, оказывается, 3 версии:

This is the FREEWARE Version of the HTML Compiler. This FREEWARE version
is for personal use only. You are required to purchase a license for any
use that results in the exchange of money or goods by using this
software.

Versions available. This version - Stand-Alone HTML Compiler PRO
Compiles HTML text and images (including frames) into a single
stand-alone executable.

Stand-Alone HTML Compiler PRO + enables the creation of shareware ebooks
and button/menu text editing.

Попытаемся сделать из Freeware -\> PRO+.

Откроем программу в ResHacker\'e. Ясное дело, повреждены все ресурсы.
Нельзя же без того, чтобы запаковать.Если хотите, можете посмотреть на
файл сквозь ваш File Analyzer. Я засунул его в Procdump32-\>PE Editor.
Ну, это наш старый знакомый UPX.

Как полагается его распаковывать:

Засунуть в Ida Pro. Найти инструкцию popad. Посмотреть куда направляется
следующий jmp xxxxxxxxx. Записать xxxxxxxxx - ImageBase как Original
Entry Point. Поставить в TRW 2000 брейкпоинт на адрес инструкции popad.
Пройти её и следующий jmp xxxxxxxxxx по F10. Сделать Suspend. Сдампить.
Выставить OEP. (не помню, он портит Import Table или нет, если да, то
восстановите)

Воспользоваться самим Upx

Проделать только в отладчике.

Я пробовал это. Только размер файла практически не увеличивается. И
делает он такие нехорошие \'Single Exe\',что быстро вешают систему.
Автораспаковщики (e.g. GUW32) вообще производят неработоспособную бурду.

Что ж, я полез в Hiew 6.11 разбираться. Когда я указал ему пойти на
адрес где-то в середине Exe\'шника, он крайне удивил меня сообщением
\'Section out of File\'. Пришлось дойти до конца секции. Посмотрите:

Как видите, после секции начинается что-то интересное. А именно новый
Exe-file. (Последовательность байт MZP).Давайте напишем программу,
которая вытащит нам его. Вот она:

    Program FileExtractor;
     
    Uses WinCrt;
     
    {Стандартные декларации}
    Var  i:longint;
         FileExe,FileDump:file of byte;
         RV:byte;
     
    begin
      Assign(FileExe,'htmlcomp.exe');
      {$I-}
      Reset(FileExe);
      {$I+}
      If IOResult<>0 then {И}
      begin
        Writeln('File not Found! Exiting...');
        Readkey;
        DoneWinCrt;
      end;
      Assign(FileDump, 'Part2.exe'); {Процедуры}
      Rewrite(FileDump);
      {Перейдём на FilePos=235520 =(39800 в шестнадцатиричной системе - см. выше}
      Seek(FileExe,235520);
      For i:=FilePos(FileExe) to (FileSize(FileExe)-1) do
      begin
        Read(FileExe,RV); {Ну и скатаем в другой файл}
        Write(FileDump,RV);
      end;
      Close(FileExe);
      Close(FileDump);
      Writeln('Done.');
      Readkey;
      DoneWinCrt;
    end.

Осторожно запустите её (Windows как бы провалится в глубокую трясину и не
будет реагировать на вас, но потом очнётся). Через ~15 секунд у вас
будет Part2.exe Аналогично вытащим первую часть.

    Program PrgExtractor;
     
    Uses WinCrt;
     
    Var  i:longint;
         FileExe,FileDump:file of byte;
         RV:byte;
     
    begin
      Assign(FileExe,'htmlcomp.exe');
      {$I-}
      Reset(FileExe);
      {$I+}
      If IOResult<>0 then
      begin
        Writeln('File not Found! Exiting...');
        Readkey;
        DoneWinCrt;
      end;
      Assign(FileDump,'Part1.exe');
      Rewrite(FileDump);
      For i:=1 to 235520 do
      begin
        Read(FileExe,RV);
        Write(FileDump,RV);
      end;
      Close(FileExe);
      Close(FileDump);
      Writeln('Done.');
      Readkey;
      DoneWinCrt;
    end.

У Part1.exe иконка как у исходной программы. У Part2.exe \-- как у
производимого программой \'Single Exe\'.Теперь понятен принцип работы
нашего приложения. Оно использует GetModuleFileName или ParamStr(0),
выдирает из себя Part2.exe, кладёт куда надо и ещё дописывает к нему
скрипт. Как это мог осуществить автор:

А1.) Как я(As File Extractor)

Б1.) Поискать последовательность байт (MZP).

Способ А1.) не подходит, потому что его нужно реализовывать, не имея
готового, сжатого EXE, да и проблематично вносить изменения в программу.
Остаётся способ Б1.).

Ну что, теперь оба файла распакуются нормально. Лучше всего
воспользоваться способом В.). Смотрим Part2.exe в REsHaCkEr\' e.

Вот наш Nag Splash Screen:

    object Form3: TForm3
    //................................................
      Caption = 'Free Splash'
      ClientHeight = 157
      ClientWidth = 392
    //................................................
      FormStyle = fsStayOnTop
      Position = poScreenCenter
    //................................................
      object Image1: TImage
    //................................................
        Width = 392
        Height = 157
        Align = alClient
        Picture.Data = {много всего в хексе }
      end
      object URLLabel1: TURLLabel
        Width = 185
        Height = 16
        Caption = 'www.bigwig.net/softwaredesign'
    //................................................
      end
      object URLLabel2: TURLLabel
    //................................................
        Width = 205
        Height = 16
        Caption = 'www.new-projects.com/booksoft'
      end
      object Label1: TLabel
        Width = 9
        Height = 13
        Caption = 'or'
    //................................................
      end
      object Timer1: TTimer
        Interval = 5000
        OnTimer = Timer1Timer
    //................................................
      end
    end

Легко догадаться, что Timer1 определяет длительность висения формы.
Внесём необходимые изменения :-)).

    object Form3: TForm3
      Caption = ''
      ClientHeight = 0
      ClientWidth = 0
      FormStyle = fsNormal
      Height = 0
      Width = 0
      object Image1: TImage
        Width = 0
        Height = 0
        Align = alNone
        Picture.Data = {убрать всё }
      end
      object URLLabel1: TURLLabel
       //................................................
       Width = 0
        Height =0
        end
      object URLLabel2: TURLLabel
        Width = 0
        Height = 0
        Caption = ''
     end
      object Label1: TLabel
        Width = 0
        Height = 0
        Caption = ''
      end
      object Timer1: TTimer
        Interval = 1
        OnTimer = Timer1Timer
      end
    end
     

Вот и всё. Nag successfully removed! Пакуем файл через UPX. Клеим его к
Part1.exe через Windows Commander 32. It works\...

Теперь разберёмся с функциональными ограничениями в Part1.exe\...
Рассматривая скриншот из хелпа, можно заметить, что в Freeware кнопка
для Securiry просто не видна.Возьмём The Customiser, исправим сиё
недоразумение(для всех подобных кнопок). Тогда everything is fine. Но
это надо не на один раз, а навсегда. Что-то в коде не хочется
копаться\..... Тем более, что тот скомпилен в Delphi 3. А Delphi кого
угодно выведет своими вложенными call\'ами. Давайте поюзаем ResHacker.

Вот скрытые кнопки:

    object Button6: TButton
        Left = 432
        Top = 4
        Width = 33
        Height = 21
        Hint = 'Edit the E-Book Security options and Viewer Text and Graphics.'
        Caption = '>>'
        ParentShowHint = False
        ShowHint = True
        TabOrder = 30
        OnClick = Button6Click
      end
    object Button7: TButton
        Left = 488
        Top = 144
        Width = 177
        Height = 25
        Hint = 'Bring up the Trial to Full Key Registration generator dialog.'
        Caption = 'Generate Registration Key'
        ParentShowHint = False
        ShowHint = True
        TabOrder = 35
        OnClick = Button7Click
      end
     object Button8: TButton
        Left = 476
        Top = 296
        Width = 201
        Height = 25
        Hint = 'Bring up the Viewer Button Graphic/Text and Menu Text editor.'
        Caption = 'Button Images/Text and Menu Text'
        ParentShowHint = False
        ShowHint = True
        TabOrder = 36
        OnClick = Button8Click
      end

Да, нехорошо. Кнопки деактивируются динамически. Раз автор(Steve Seymor)
так к нам относится, то и мы отнесёмся к нему соответственно. Сделаем
копии всех этих кнопок и изменим немного. e. g. object Button8:
TButton-\>object Mutton8: TButton Можете зайти в TFORM2 и поменять там
чего-нибудь :-)). Запустим программу. Wow! Никаких ограничений! Пакуем
через UPX . Склеиваем с Part2.exe\.... N.B. наш файл меньше исходного
!!! N.B. Мы не использовали ни дизассемблер, ни отладчик!!!

OK, всё работает! Засуньте Cracked Exe в архив и добавьте \*.nfo;

Greates to:авторам всех использованных инструментов, Dr. Golova.

TNT Team, которая распространяет свой тормознутый неработающий загрузчик
для этого продукта, Must Die.

Файлы, использованные при исследовании:

fextract.zip

prgextract.zip

Created by Wersion

E-mail: wcrkgroup2002\@mail.ru

Site: http://expwinprg.cjb.net/

Вопросы/Пожелания/Угрозы/Комментарии \-- приветствуются.

Взято с <https://delphiworld.narod.ru>
