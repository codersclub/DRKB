---
Title: Текст с эффектами
Author: Релорт
Date: 01.01.2007
---


Текст с эффектами
=================

::: {.date}
01.01.2007
:::

Автор: Релорт

WEB-сайт: http://daddy.mirgames.ru



Введение.
Вам когда-нибудь хотелось организовать вывод текста, да не простого, а с
наворотами. Так вот эта статья как раз про это. Читайте!

Благодарность...
Сайту Daddy.h1.ru (MirGames.ru) за то, что там можно найти информацию по
DelphiX и скачать файлы со шрифтами :) Большое спасибо!

... и информация.
Прошу прошения у тех, кто писал на Relort@xaker.ru в последнее время,
за то, что не ответил. В течение последнего месяца я не мог «достучатся»
до своего ящика. И вот буквально вчера узнал, что тот на время накрылся
:( Так что повторите свои отклики, просьбы, пожелания на новый
электронный адрес.

Также убедительная просьба присылать интересующие вас темы, и если я
что-либо смогу по ним сказать, то обязательно это сделаю, оформив ответы
в статьи. ОК?

Часть 1. Базовый класс.
Лирическое отступление: давайте договоримся, что все новые классы и тому
подобное мы будем размешать в отдельных файлах. ОК? По крайне мере я
собираюсь делать именно так... Итак, создаем новый проект, кидаем на
форму TDXDraw, TDXTimer. Теперь создаем новый Unit и обзываем его,
например, TextWithEffect\_Unit.pas. Приготовления закончены.
Приступаем.

Рассуждаем: текст состоит из слов, слова из букв. Вот почему первым
созданием в Unit'е будет:

    TLetterEffect = record
       Visible: Boolean; //видима ли буква
       CurTime, Delay: Integer; //...
       Scale: Integer; //это и будет нашим эффектом (уменьшение)
    end;
     
    TLetterEffectArray = array of TLetterEffect;
    PLetterEffectArray = ^TLetterEffectArray;

То есть описание буквы текста и определение массива букв. Сразу за ним
пишем:

     
    TTextWithEffect = class
    private
       FontSurface: TDirectDrawSurface;
       TextSurface: TDirectDrawSurface;
       FText: String;
       FFontSize: Integer;
       FState: Integer;
       FFileName: String;
       LetterEffect: TLetterEffectArray;
       procedure SetText(const Value: String);
       procedure Error(ErrorType: Integer);
       procedure SetFontSize(const Value: Integer);
       procedure SetFileName(const Value: String);
    public
       property Text: String read FText write SetText;
       property FontSize: Integer read FFontSize write SetFontSize;
       property FileName: String read FFileName write SetFileName;
       procedure Draw(Surface: PDirectDrawSurface);
       constructor Create(DD: PDirectDraw);
       destructor Destroy;
    end;

Надеюсь здесь все понятно? Нет!? Ну тогда ладно:
FontSurface - поверхность (TDirectDrawSurface), содержащая алфавит.
TextSurface - поверхность (TDirectDrawSurface), содержащая текст к
выводу.
LetterEffect - буквы текста.
Text - текст к отрисовке.
FontSize - размер каждой буквы текста. Здесь надо оговорится: каждая
буква текста берется из файла с именем FileName (третье свойство
TTextWithEffect), т. е. FileName - имя файла с алфавитом (см. архив,
прилагаемый к статье, файл Font.bmp); и для заполнение TextSurface'а
необходим размер каждой буквы.
Ну и так далее...

А сейчас самое интересное: создание эффекта и просмотр результата.

Часть 2. Эффект и отрисовка.

Для данного примера я опишу лишь один эффект - уменьшение букв с
течением времени. Этот эффект довольно просто реализовать с учетом
вышеописанного класса TLetterEffect. В том классе за текущее состояние
эффекта буквы отвечала переменная Scale. Все что нам нужно - уменьшать
ее во времени (но до определенного момента).

А вот и сама процедура, принимающая в качестве аргумента указатель на
массив букв. Вот...

    //Эффект
    procedure ScaleDown(L: PLetterEffectArray);
    var
       i: Integer;
    begin
       for i:=0 to High(L^) do
       begin
          if L^[i].Scale < 0 then
          begin
             inc(L^[i].CurTime);
             if L^[i].CurTime <= L^[i].Delay then
             dec(L^[i].Scale, 1);
             exit;
          end;
       end;
    end;
    // ну и отрисовка
    procedure TTextWithEffect.Draw(Surface: PDirectDrawSurface);
    var
       i: Integer;
       rc: TRect;
       rc1: Trect;
       s: Integer;
    begin
       if FontSurface = nil then exit;
       if FText = '' then exit;
       // рисуем текст без эффекта
       Surface^.Draw(32, 32, TextSurface.ClientRect, TextSurface, True);
       // вносим изменения в эффект
       ScaleDown(@LetterEffect);
       // и выводим текст с эффектом побуквенно
       for i:=0 to High(LetterWithEffect) do
       begin
          s := LetterEffect[i].Scale;
          if s = 32 then exit;
          rc1 := Rect(i*16,0,(i+1)*16,16);
          if s < 0 then
          begin
             rc := Rect(i*16+32-s, 64-s, ((i+1)*16)+32+s, 80+s);
             Surface^.StretchDraw(rc, rc1, TextSurface, True);
          end
          else Surface^.Draw(i*16+32, 64, rc1, TextSurface, True)
       end;
    end;

Заключение.
Посмотрите файл TWE\_Ex.exe.
Вот чего можно добиться расширив данный пример :) !!!


Ну вот вроде бы как и все. Мы добрались до завершения статьи. Если что
непонятно, необходимо пояснение или пример пишите. Отвечу всем.

Автор: Релорт Relort@yandex.ru Февраль 2003.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
