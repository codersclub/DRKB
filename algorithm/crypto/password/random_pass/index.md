---
Title: Генерация случайного пароля
Author: Archer
Date: 01.01.2007
---


Генерация случайного пароля
===========================

::: {.date}
01.01.2007
:::

    function RandomPassword(PLen: Integer): string;
     var
       str: string;
     begin
       Randomize;
       //string with all possible chars 
      str    := 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
       Result := '';
       repeat
         Result := Result + str[Random(Length(str)) + 1];
       until (Length(Result) = PLen)
     end;
     
     procedure TForm1.Button1Click(Sender: TObject);
     begin
       //generate a password with 10 chars 
      label1.Caption := RandomPassword(10);
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>

------------------------------------------------------------------------

     // Another function from ReNoiZer /=RNZ=/; renoizer@mail.ru 
     
    function RandomWord(dictSize, lngStepSize, wordLen, minWordLen: Integer): string;
     begin
       Result := '';
       if (wordLen < minWordLen) and (minWordLen > 0) then
         wordLen := minWordLen
       else if (wordLen < 1) and (minWordLen < 1) then wordLen := 1;
       repeat
         Result := Result + Chr(Random(dictSize) + lngStepSize);
       until (Length(Result) = wordLen);
     end;
     
     procedure TForm1.Button2Click(Sender: TObject);
     begin
       //generate a password with 10 chars 
      Caption := RandomWord(33, 54, Random(12), 2);
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>

------------------------------------------------------------------------

Hi всем! Начнём с того что кинем на форму три Edit -а, Батон (Button),
два GroopBox-a, popUp меню и UpDown. На одну панель бросаем три
RadioButton-a, на другую три CheckBox-a. Ассоциируем UpDown с первым
Edit-ом, здесь будет выбор кол-ва букв в пароле. Второй Edit будет для
вывода пароля, а третий для побуквенного вывода сгенереного пароля.
CheckBox-ы называем C1,C2,C3,C4,C5. RadioButton-ы называем Ra1,Ra2,Ra3.
В меню делаем два пункта, их каптионы называем +10 и -10. Caption-ы
CheckBox-ов обзываем \'Латиница\',\'Кирилица\',\'0..9\',\'Спецсимволы \'
и \'Смесь\'. Это для выбора символов из которых генерится пароль.
Caption-ы RadioButton-ов обзываем \'Upper Case\' \'Lower Case\' \'Misc\'
-для выбора регистра. Один CheckBox и RadioButton делаем выделеными по
умолчанию. Батон используем как стартовую кнопку. А дальше смотрите код:

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls, Spin, ExtCtrls, Menus, ComCtrls, Buttons;
     
    type
      TForm1 = class(TForm)
        Gen: TButton;
        Label1: TLabel;
        Status: TStatusBar;
        PopupMenu2: TPopupMenu;
        N101: TMenuItem;
        N102: TMenuItem;
        edit2: TEdit;
        edit3: TEdit;
        edit1: TMemo;
        U1: TUpDown;
        C1: TCheckBox;
        C2: TCheckBox;
        C3: TCheckBox;
        C4: TCheckBox;
        C5: TCheckBox;
        Ra1: TRadioButton;
        Ra2: TRadioButton;
        Ra3: TRadioButton;
        GroupBox1: TGroupBox;
        GroupBox2: TGroupBox;
        procedure GenClick(Sender: TObject);
        procedure FormCreate(Sender: TObject);
        procedure N101Click(Sender: TObject); {Обработка пунктов меню}
        procedure N102Click(Sender: TObject); {Обработка пунктов меню}
        procedure SpinKeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);
        procedure edit1KeyPress(Sender: TObject; var Key: Char);
      private
        { Private declarations }
      public
        { Public declarations }
    end;
     
    var
      Form1: TForm1;
      kol: integer;
      ss: string;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.GenClick(Sender: TObject);
    label
      1;
    const
      con1='qwertyuiopasdfghjklzxcvbnm';
      con2='QWERTYUIOPASDFGHJKLZXCVBNM';
      con3='qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
      con4='!@#$%^&*()_+|\=-<>.,/?''; :"][}{';
      con5='йцукенгшщзхъфывапролджэячсмитьбю';
      con6='ЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮ';
      con7='йцукенгшщзхъфывапролджэячсмитьбюЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮ';
    var
      s: string;
      r, m, k, l: integer;
    begin
      randomize;
      if edit1.text<>'' then
        kol:=strtoint(edit1.text)
      else
      begin
        goto 1;
      end;
      begin
        edit2.text:='Введите значение...';
      end;
      edit3.clear; status.simpletext:='Подождите, пароль генерируется...';
      repeat
        r:=random(8)+1;
        if kol>0 then
          if (c1.Checked=true) or (c2.Checked=true) or
          (c3.Checked=true) or (c4.Checked=true) then
            case r of
              1:if (c2.Checked=true) and (ra1.Checked=true) then
                  s:=s+con1[random(25)+1];
              2:if (c2.Checked=true) and (ra2.Checked=true) then
                  s:=s+con2[random(25)+1];
              3:if (c2.Checked=true) and (ra3.Checked=true) then
                  s:=s+con3[random(49)+1];
     
              4:if c4.Checked=true then
                  s:=s+con4[random(30)+1];
              5:if c1.Checked=true then
                  s:=s+inttostr(random(10));
     
              6:if (c3.Checked=true) and (ra1.Checked=true) then
                  s:=s+con5[random(31)+1];
              7:if (c3.Checked=true) and (ra2.Checked=true) then
                  s:=s+con6[random(31)+1];
              8:if (c3.Checked=true) and (ra3.Checked=true) then
                  s:=s+con7[random(63)+1];
            end
        else
        begin
          s:='Выберите символы которые вы хотите использовать';
          kol:=length(s);
        end;
      until
        length(s)>=kol;
      while length(s)>kol do
        delete(s,1,1);
     
      1:
      if edit1.text='' then
      begin
        s:='Выберите кол-во символов в пароле!';
        kol:=length(s);
        status.simpletext:='Выберите кол-во символов в пароле!';
        edit2.text:=s;
        edit3.text:= 'Выберите кол-во символов в пароле!';
      end
      else
      begin
        edit2.text:=s;
        for m:=1 to kol do
          edit3.text:=edit3.text+' '+s[m];
      status.simpletext:='Пароль готов!';
      end;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      edit2.clear;edit3.clear;
      edit2.text:='Здесь будет пароль!';
      u1.position:=8;
      edit3.text:='А здесь каждый символ отдельно!'; kol:=0;
    end;
     
    procedure TForm1.N101Click(Sender: TObject);
    begin
      u1.position:=u1.position+10
    end;
     
    procedure TForm1.N102Click(Sender: TObject);
    begin
      if u1.position>10 then
        u1.position:=u1.position-10
      else
        status.simpletext:='Слишком маленькое значение!!!';
    end;
     
    procedure TForm1.SpinKeyDown(Sender: TObject; var Key: Word;
    Shift: TShiftState);
    begin
      if (key=13) then genclick(gen) ;
    end;
     
    procedure TForm1.edit1KeyPress(Sender: TObject; var Key: Char);
    begin
      if not (key in ['0'..'9']) then key:=#0;
    end; 
     
    end.
     
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

Вам понадобилось, чтобы Ваше приложение само создавало пароли ? Возможно
данный способ Вам пригодится. Всё очень просто: пароль создаётся из
символов, выбираемых случайным образом из таблицы.

Пароль создаётся из символов, содержащихся в таблице.

Внимание:

Длина пароля должна быть меньше, чем длина таблицы!

Запускаем генератор случайных чисел (только при старте приложения).

    procedure TForm1.FormCreate(Sender: TObject);
    begin
      Randomize;    
    end;

Описываем функцию:

    function RandomPwd(PWLen: integer): string;
    // таблица символов, используемых в пароле
    const StrTable: string =
      '!#$%&/()=?@<>|{[]}*~+#;:.-_' +
        'ABCDEFGHIJKLMabcdefghijklm' +
        '0123456789' +
        'ДЦЬдцьЯ' +
        'NOPQRSTUVWXYZnopqrstuvwxyz';
    var
      N, K, X, Y: integer;
    begin
      // проверяем максимальную длину пароля
      if (PWlen > Length(StrTable)) then
        K := Length(StrTable)-1
      else
        K := PWLen;
      SetLength(result, K);              // устанавливаем длину конечной строки
      Y := Length(StrTable);             // Длина Таблицы для внутреннего цикла
      N := 0;                            // начальное значение цикла
     
      while N < K do                     // цикл для создания K символов
      begin
        X := Random(Y) + 1;              // берём следующий случайный символ
        // проверяем присутствие этого символа в конечной строке
        if (pos(StrTable[X], result) = 0) then
        begin
          inc(N);                        // символ не найден
          Result[N] := StrTable[X];      // теперь его сохраняем
        end;
      end;
    end;

Ну и обработчик нажатия кнопки будет выглядеть так:

    procedure TForm1.Button1Click(Sender: TObject);
    var
      cPwd: string;
    begin
      // вызываем функцию генерации пароля из 30 символов
      cPwd := RandomPwd(30);
      // ...
    end;
     
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

Автор: Archer

Тут поговорим случайных паролях с точки зрения математики. Конкретнее -
как количество возможных вариантов пароля зависит от его длины и
размерности используемого при генерации \"алфавита\". Тема не новая, но
ни в одной статье на эту тему (во всяком случае из тех, что я читал)
вопрос не рассматривается достаточно подробно. Частенько просто
отделываются утверждением, что возможных вариантов паролей \"огромное
количество\". Но это понятие растяжимое - современный ПК тоже выполняет
\"огромное количество\" операций в секунду. Так сколько ему понадобится
времени, чтобы при переборе вариантов добраться до нашего пароля? Особо
продвинутые авторы пугают читателя огромными числами. Не будем верить на
слово - если мы пишем программу, в которой предусмотрены пароли, надо
самим уметь оценить их надежность. Не вдаваясь в строгое математическое
доказательство, посмотрим, откуда берутся эти зверские числа и как их
рассчитать для каждого конкретного случая.

Давайте договоримся, что мы имеем алфавит из n возможных символов, а наш
пароль k символов в длину. Надо узнать, сколько вариантов пароля может
быть в принципе, и дополнительно посмотрим, сколько будет вариантов
паролей из неповторяющихся символов - иногда встречаются утверждения,
что такой пароль лучше. Не ручаюсь за точность терминологии, лень было
искать:), просто для себя назовем такие пароли соответственно
\"обычными\" и \"уникальными\".

Обычные пароли

Как мы только что договорились, обычными называем пароли, которые могут
содержать повторяющиеся символы. То есть это полное количество
комбинаций длиной k, которые мы можем составить из n элементов. Слишком
сильно в математику вдаваться не будем, а рассмотрим несколько простых
примеров. Начнем как положено, с самого начала.

Пример 1: У нас есть элементы \"А\" и \"В\". Сколько комбинаций длиной 1
можно из них сотворить? Очевидно, две. Попутно отмечаем на будущее, что
это равно nk.

Пример 2: У нас есть элементы \"А\", \"В\" и \"С\". Сколько имеем
комбинаций длиной в 2 символа? Давайте считать. Перебираем по принципу
\"каждый с каждым\". Получаем \"АА\", \"АВ\", \"АС\", \"ВА\", \"ВВ\",
\"ВС\", \"СА\", \"СВ\", \"СС\", всего 9. Занятное совпадение - снова nk
:)

Дальше предлагаю просто принять на веру, что их nk, поскольку так оно и
есть, строго доказывать будет длинновато. Интересующиеся могут
обратиться к разделу алгебры \"Комбинаторика\". Это называется
размещения с повторениями. Рассмотрим более практический пример. Число
букв английского алфавита 26. Составляем всевозможные пароли длиной в 9
символов. Их у нас 269=5 429 503 678 976 штук. Для начала неплохо:)

Уникальные пароли

Снова вернемся к примерам. Уникальные пароли не содержат повторяющихся
символов, потому первый пример оставляет нам оба варианта. Из второго
примера мы должны вычеркнуть \"АА\", \"ВВ\" и \"СС\", то есть имеем
шесть случаев. В математике это называется размещениями. Количество
размещений (без повторения) рассчитываем по формуле
n*(n-1)*(n-2)*...*(n-k+1) = n! / (n-k)! (что такое факториал,
надеюсь, все помнят). Сразу видим, что для наших примеров получаем
соответственно 2 и 6, то есть все правильно. Снова тот же более
практический пример - на этот раз имеем 26! / (26 - 9)! = 26! / 17! = 1
133 836 704 000 вариантов. Даже без \"куркулятора\" понятно, насколько
мы сузили диапазон возможных паролей наложением условия неповторяемости
символов. Это к вопросу об использовании \"уникальных\" паролей:)

Реальный пример

Давайте перейдем к практическим вещам. Например, рассмотрим пароли MS
Office. Они могут быть до 15 знаков в длину, включать буквы (не только
английские, но и языков локализации), цифры, а также специальные символы
(\"{\", \"\#\", \"!\" и т.п.). Кроме того, учитывается регистр символов,
то есть английских букв реально можем использовать 52. Надо отметить,
что MS Office ничего не имеет против пароля, состоящего из букв разных
языков, но я бы не стал такого делать - легко самому запутаться. Потому
прикидываем для английского - 52 буквы, 10 цифр, еще пару десятков надо
накинуть на спецсимволы... Для круглого счета определим наш алфавит в
80 символов. Максимальное количество паролей максимальной длины при
таком допущении будет примерно 3,5 * 1028. А если не допускать
повторения символов? 8,6 * 1027. Снова вариантов в несколько раз
меньше.

Зависимости

Попробуем ответить на самый интересный вопрос - как количество вариантов
зависит от размерности алфавита и длины пароля? И что вообще важнее -
увеличивать размерность алфавита или использовать пароль максимальной
длины? Формулы этих зависимостей мы уже получили, для наглядности теперь
нарисуем пару картинок. Снова берем 80 символов алфавита и 15 символов
пароля.

![clip0102](clip0102.png)

Рисунок 1: Зависимость количества "обычных" вариантов
от размерности алфавита и длины пароля.

К сожалению, \"рисовалка\" немного не дотягивает до максимальных
значений, но все закономерности налицо. На мой взгляд, рисунки
показывают, что минимально приемлимый пароль имеет от 10 символов в
длину и от 25 символов использованного алфавита, и что количество
вариантов сильнее зависит от размерности алфавита.

Так сколько же компьютеру понадобится времени для взлома нашего
документа? Давайте оценим. Специально заходил на сайты нескольких утилит
для \"восстановления забытых паролей\", но сведений о скорости перебора
там благоразумно не приводилось:) Единственное, что удалось откопать в
сети - упоминание о том, что одна из таких программ, написанная
несколько лет назад, перебирает 85000 вариантов в секунду на Pentium
III. В алгоритмах с тех пор вряд ли что-то существенно изменилось.
Давайте введем поправку на возросшие компьютерные мощности, например,
помножим на пять. Для 9-ти значного пароля и для алфавита в 26 символов
получится около 145 суток. Это для обычных паролей. Для паролей из
неповторяющихся символов получается ровно месяц. Конечно, эти расуждения
относятся к взлому пароля прямым перебором вариантов - относительно иных
способов не берусь подсчитать.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
