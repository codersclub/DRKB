---
Title: O сохранении иконок 32х32 в 256-цветном формате
Date: 01.01.2007
---

O сохранении иконок 32х32 в 256-цветном формате
===============================================

::: {.date}
01.01.2007
:::

Высылаю Вам информацию для FAQ о сохранении иконок 32х32 в 256-цветном

формате. Распоряжайтесь ею как Вам нужно. Размер кода большой, думаю для
FAQ

не годится, скорее для раздела \"Обмен опытом\", но Вам видней. И
сообщите,

пожалуйста, где эта информация будет размещена, чтоб не посылать
каждому,

кто обратится, все описание, а просто дать ссылку.

С уважением, Владимир, г.Иркутск, nsvi\@hotbox.ru

Суть вопроса: я столкнулся с проблемой сохранения полноцветных иконок,
когда

понадобилось немного изменить имеющиеся у меня для своих программ. Ни
родной

Image Editor от Delphi6, ни другие редакторы не смогли мне помочь. Могли
это

делать платные редакторы, но они не для нас. Начав разбираться, я
обнаружил,

что созданная функцией CreateIconIndirect иконка нормально выглядит,
если

после создания ее кинуть на форму, однако после записи Icon.SaveToFile

иконка обезображивается. Это происходит на стадии записи иконки. Поискав

информацию, облазив форумы, я понял, что либо этой проблемой никто не

занимался, либо с ней все мирятся и заниматься не хотят, хотя
интересующиеся

имеются.

Став заниматься проблемой вплотную, я решил использовать
нетипизированные

файлы, которым все равно, что в них записывают. Эти файлы хорошо
подходят

для работы с массивами байт и, если создать массив полностью
соответствующий

структуре иконки, то записав массив в нетипизированный файл, получим
искомую

иконку.

Пришлось изучить структуру файла ICO и вот результат.

Для использования процедуры нет необходимости изучать файл ICO, если
только

вы не хотите ничего изменять, например, размеры иконки. В принципе,
можно

сделать универсальную процедуру, которая бы определяла размер иконки и,
в

соответствии с размерами, создавала иконку. Все адреса и размеры,
указанные

в процедуре, являются абсолютными и изменению не подлежат, так как
именно от

них зависит, будет ли соответствовать создаваемый массив файлу ICO.

В процедуру введено автоопределение количества цветов палитры, от этого

зависит структура файла. Вам нет нужды указывать количество используемых

цветов.

Кроме того, введено определение размера рисунка и если он не 32х32, то

процедура прекратит работу. Это произойдет и в случае если кому-то
захочется

использовать более 256 цветов. Тем, кто хочет узнать о структуре файлов
ICO,

читать после кода процедуры.

Используя этот метод можно работать с любыми файлами, например, для
открытия

и побайтного изменения EXE-файлов.

Для работы этой процедуры нужен рисунок 32х32 на канве (у меня Image2),

диалоговое окно SaveDialog1 (но не SavePictureDialog1)

и все. Если нужно, измените имя канвы, оно встречается в двух строчках
кода,

и имя диалогового окна. Процедура с комментариями ниже:

//Записываем картинку как иконку (файл .ico)

{Так как стандартные функции не дают возможности создавать 256 цветные

иконки, мы пойдем другим путем, хоть он и медленнее и длиннее.

Создадим массив байт, который запишем как файл, это и будет

искомая иконка. Для этого создадим промежуточные массивы, иначе
процедура

станет слишком навороченной, затем проверим количество используемых
цветов

и, в зависимости от этого, создадим окончательный массив.}

    procedure TForm1.ToolButton6Click(Sender: TObject);
    var
      MAnd, MXor, MOsn, MCol: array of Byte;
      MPix, MOrg: array of TColor;
      a, b, c, n, m: integer;
      Bt, Bu, Indicator: Byte;
      p: TColor;
      k: boolean;
      F: file;
      LenOsn, LenXor, LenCol: integer;
    begin
      if (Image2.Picture.Height <> 32) or (Image2.Picture.Width <> 32) then
        begin
          ShowMessage('Исходный рисунок не 32х32');
          exit;
        end;
    {Создание массивов: MAnd - массив маски AND, MXor - массив маски Xor,
    основного массива MOsn - куда будет собираться вся информация,
    массив MPix - массив пикселов рисунка начиная с левого нижнего угла,
    MCol - массив таблицы цветов - палитры, MOrg - массив оригинальных цветов}
    {Заполнение массивов MPix и MAnd}
    {Активизация массивов}
      SetLength(MPix, 1024);
      SetLength(MAnd, 128);
    {Установка счетчиков}
      b := 0; //Счетчик битов
      a := 0; //Счетчик пикселов картинки
      c := 0; //Счетчик байтов маски MAnd
      Bt := 0; //Формируемый байт маски MAnd
    {Преобразование картинки в удобный формат, с началом от 0,
    и перенос ее в таком виде в массив MPix, меняя по пути белый -
    будущий прозрачный цвет - на черный, заодно заполняем массив MAnd}
      for m := 31 downto 0 do
        for n := 0 to 31 do
          begin
            MPix[a] := Image2.Canvas.Pixels[n, m];
            p := MPix[a];
            if p = RGB(255, 255, 255) then
              begin
                MPix[a] := RGB(0, 0, 0);
                if b = 0 then
                  Bt := Bt + 128;
                if b = 1 then
                  Bt := Bt + 64;
                if b = 2 then
                  Bt := Bt + 32;
                if b = 3 then
                  Bt := Bt + 16;
                if b = 4 then
                  Bt := Bt + 8;
                if b = 5 then
                  Bt := Bt + 4;
                if b = 6 then
                  Bt := Bt + 2;
                if b = 7 then
                  Bt := Bt + 1;
              end;
            b := b + 1;
            if b = 8 then
              begin
                MAnd[c] := Bt;
                Bt := 0;
                c := c + 1;
                b := 0;
              end;
            a := a + 1;
          end;
    {Заполнение маски MOrg нулями, предполагая 256 цветов}
      SetLength(MOrg, 256);
      for n := 0 to 255 do
        MOrg[n] := RGB(255, 255, 255);
    {Оцениваем количество цветов и от результата переделываем MOrg}
      a := 0; //Счетчик количества цветов
      for n := 0 to 1023 do
        begin
          p := MPix[n];
          k := false;
          for m := 0 to 255 do
            begin
              if k = false then
                if p = MOrg[m] then
                  k := true;
            end;
          if k = false then
            begin
              if a > 255 then
                begin
                  ShowMessage('Ваш рисунок имеет более 256 цветов');
                  MOrg := nil;
                  MPix := nil;
                  MAnd := nil;
                  exit;
                end;
              MOrg[a] := p;
              a := a + 1;
            end;
        end;
      LenOsn := 2238;
      LenXor := 1024;
      LenCol := 1024;
      Indicator := 1;
      if a < 15 then
        begin
          LenOsn := 766;
          LenXor := 512;
          Indicator := 0;
        end;
    {Заполняем маски нулями}
      SetLength(MXor, LenXor);
      SetLength(MCol, LenCol);
      for n := 0 to LenXor - 1 do
        begin
          MXor[n] := 0;
        end;
      for n := 0 to LenCol - 1 do
        begin
          MCol[n] := 0;
        end;
    {Заполнение массива MXor согласно массива MPix}
      Bu := 0;
      b := 0;
      c := 0;
      for n := 0 to 1023 do
        begin
          p := MPix[n];
          k := false;
          for Bt := 0 to 255 do
            begin
              if k = false then
                if p = MOrg[Bt] then
                  begin
                    k := true;
                    if indicator = 1 then
                      MXor[n] := Bt
                    else if b = 1 then
                      begin
                        Bu := 16 * Bu + Bt;
                        MXor[c] := Bu;
                        c := c + 1;
                        b := 0;
                      end
                    else
                      begin
                        Bu := Bt;
                        b := 1;
                      end;
                  end;
            end;
        end;
    {Заполняем массив MCol согласно массива MOrg}
      begin
        a := 0;
        for n := 0 to 255 do
          begin
            p := MOrg[n];
            MCol[a] := GetBValue(p);
            MCol[a + 1] := GetGValue(p);
            MCol[a + 2] := GetRValue(p);
            a := a + 4;
          end;
      end;
    {Заполняем MOsn нулями}
      SetLength(MOsn, LenOsn);
      for n := 0 to LenOsn - 1 do
        MOsn[n] := 0;
    {Заполняем массив MOsn для 256 цветной иконки}
      if indicator = 1 then
        begin
          MOsn[2] := 1;
          MOsn[4] := 1;
          MOsn[6] := 32;
          MOsn[7] := 32;
          MOsn[14] := $A8;
          MOsn[15] := 8;
          MOsn[18] := $16;
          MOsn[22] := $28;
          MOsn[26] := 32;
          MOsn[30] := $40;
          MOsn[34] := 1;
          MOsn[36] := 8;
          MOsn[42] := $80;
          MOsn[43] := 4;
          MOsn[55] := 1;
          m := 0;
          for n := 62 to 1085 do
            begin
              MOsn[n] := MCol[m];
              m := m + 1;
            end;
          m := 0;
          for n := 1086 to 2109 do
            begin
              MOsn[n] := MXor[m];
              m := m + 1;
            end;
          m := 0;
          for n := 2110 to 2237 do
            begin
              MOsn[n] := MAnd[m];
              m := m + 1;
            end;
        end;
    {Заполняем массив MOsn для 16-цветной}
      if indicator = 0 then
        begin
          MOsn[2] := 1;
          MOsn[4] := 1;
          MOsn[6] := 32;
          MOsn[7] := 32;
          MOsn[8] := 4;
          MOsn[14] := $E8;
          MOsn[15] := 2;
          MOsn[18] := $16;
          MOsn[22] := $28;
          MOsn[26] := 32;
          MOsn[30] := 64;
          MOsn[34] := 1;
          MOsn[36] := 4;
          MOsn[43] := 2;
          MOsn[54] := 16;
          m := 0;
          for n := 62 to 125 do
            begin
              MOsn[n] := MCol[m];
              m := m + 1;
            end;
          m := 0;
          for n := 126 to 637 do
            begin
              MOsn[n] := MXor[m];
              m := m + 1;
            end;
          m := 0;
          for n := 638 to 765 do
            begin
              MOsn[n] := MAnd[m];
              m := m + 1;
            end;
        end;
    {Закрываем все массивы, кроме MOsn}
      MAnd := nil;
      MXor := nil;
      MOrg := nil;
      MCol := nil;
      MPix := nil;
    {Записываем массив MOsn в файл, для этого создаем нетипизированный файл,
    активизируем его и побайтно пишем в него данные из массива MOsn}
      if SaveDialog1.Execute then
        begin
          AssignFile(f, SaveDialog1.FileName + '.ico');
          Rewrite(f, 1);
          for n := 0 to LenOsn - 1 do
            begin
              Bt := MOsn[n];
              BlockWrite(f, Bt, 1);
            end;
          CloseFile(f);
          MOsn := nil;
        end;
    end;

Существуют иконки более сложной структуры. Они могут содержать несколько

рисунков. Я с ними не разбирался.

Может быть кто-то из профессионалов скажет - примитивщина, нагородил. Ну
что

ж, может быть есть пути проще и лучше, но когда я спрашивал на форумах
никто

не смог помочь. Главное, работает без проблем.

Я всего месяц как познакомился с Delphi и Паскалем, думаю

можно кое-что и простить.

О структуре иконки. Информации немного в интернете, но кое-что я
раскопал.

Пришлось просмотреть коды разных иконок, чтобы иметь о них
представление.

Файл ICO очень похож на BMP:

в начале файла заголовок BITMAPFILEHEADER, размером обычно 22 байта. В
нем

содержится информация о файле. За ним идет BITMAPINFOHEADER, 40 байт,

содержит информацию о ширине и высоте иконки в пикселах, количество бит
на

пиксел в структуре картинки, занимаемое место таблицей цветов и другая

информация. Для примера оба заголовка для 16-цветной иконки.

В квадратных скобках номер байта в файле, далее эго значение.

\[2\] := 1; // Всегда 1

\[4\] := 1; // Всегда 1

\[6\] := 32; // Ширина и

\[7\] := 32; // высота в пикселах?

\[8\] := 4 // Не знаю

\[14\] := \$E8; // Младший байт размера файла минус 22(размер
BITMAPFILEHEADER)

\[15\] := 2; // Старший байт размера файла

\[18\] := 22; // Размер BITMAPFILEHEADER

\[22\] := 40; // Размер заголовка BITMAPINFOHEADER

\[26\] := 32; // Ширина в пикселах

\[30\] := 64; // Высота в пикселах обоих масок в сумме

\[34\] := 1; // Число плоскостей

\[36\] := 4; // бит/пиксел для таблицы пикселов

\[43\] := 2; // Старший байт размера таблицы пикселов (т.е.\$200=512)

\[54\] := 16; // Число используемых цветов (не обязательно)

Остальные не указанные байты и до адреса 62 все 0.

После заголовков находится таблица цветов.

Каждый цвет занимает 4 байта. По порядку - синий, зеленый, красный и
нулевой

байты. Первые 3 байта образуют цвет пиксела. То есть, каждый пиксел на

иконке может иметь 256х256х256 оттенков. При 16 цветной иконке таблица

цветов занимает 16х4=64 байта, при 256 цветной - 1024 байта. По идее,
при

записи иконки любая программа должна просканировать иконку и все
найденные

цвета записать в таблицу.Почему этого не происходит я не знаю. Windows
эти

цвета при записи игнорирует и устанавливает свои.

Если же при 16 цветной палитре используются только, допустим, 6 цветов,
то

остальные 10 цветов не нужны, однако место для них остается, но оно не

используется.

Следующим блоком в файле идет таблица пикселов. Первый пиксел это самый

нижний в левом углу. И переписываются они в таблицу построчно. Основной

параметр, по которому таблица организуется, это количество бит на
пиксел.

Каждый элемент этой таблицы - это номер цвета в таблице цветов. При
выводе

на экран иконки берется очередной элемент, то есть номер цвета в таблице

цветов, берет по номеру цвет из таблицы цветов и этот цвет выводится на

экран. Так как для определения номера в таблице из 16 цветов достаточно
4

бит, то каждый байт таблицы пикселов определяет 2 пиксела. Причем,
младшие 4

разряда относятся к первому, а старшие - к следующему пикселам.

Для 256 цветов необходим полный байт. Поэтому, таблица пикселов занимает

соответственно 512 и 1024 байтов.

Таблица пикселов это образ маски XOR иконки, цвет, который должен быть

прозрачным, заменен черным, в остальном же это рисунок, который вы
создали в

редакторе.

И последним идет таблица маски AND. Это двухцветная маска вашего
рисунка,

имеет только белый цвет (бит включен) и черный цвет (бит равен 0). Белый

цвет находится там, где будет прозрачный цвет, черный скрывает все

остальное. При наложении двух масок друг на друга тот пиксел, у которого
на

маске AND белый, а на маске XOR черный цвет, будет невидим.

Так как маска AND монохромная, то один байт содержит информацию о 8

пикселах, а размер маски будет 1024/8=128 байт.

Имеем:

для 16-цветной иконки размер 22+40+64+512+128=766 байт,

для 256 - 22+40+1024+1024+128=2238 байт.

Создав массив из соответствующим образом пребразованного рисунка, мы
можем

записать его байты в нетипизированный файл, которому все равно, что в
нем

находится, добавив к имени расширение .ico, мы получим то, что было
нужно.

Конечно, есть разные варианты размеров иконок, у них могут меняться
размеры

заголовков, использоваться другая информация, но структуры эти должны

присутствовать. Существуют иконки гораздо большие размером, но я с
такими не

разбирался.

Взято с Vingrad.ru <https://forum.vingrad.ru>