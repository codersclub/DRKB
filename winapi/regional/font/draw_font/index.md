---
Title: Нормальная процедура отображения графических шрифтов
Author: Spose
Date: 01.01.2007
---

Нормальная процедура отображения графических шрифтов
====================================================

::: {.date}
01.01.2007
:::

Автор: Spose

WEB-сайт: http://daddy.mirgames.ru

Сразу рассмотрим плюсы и минусы помещения каждой буквы в отдельное
изображение!

Плюсы :

1. Более быстрая отрисовка (так как ищется только номер картинки).

2. Буквы рисуются аккуратно, на одинаковом расстоянии друг от друга.

Минусы:

1. Много файлов (256 штук) - этот минус отпадает сам, так как я буду
использовать псевдо архив.

2. Довольно медленная загрузка (надо прочитать архив и повторить
процедуру загрузки картинки в память 256 раз)

Сначала нам нужны все символы от 1 до 256 в BMP формате (желательно 256
цветов) из них и будет состоять шрифт. Сейчас мы напишем программу
сохраняющая ваши символы в псевдо архив fnt. Создаем проект и после
слова TYPE пишем:

    Thead=record //Заголовок fnt файла
       count:integer; //Количество изображений (вдруг вам русский шрифт не нужен а нужен только английский - тогда картинок будет 128
       name:string[5]; //Имя шрифта (нужно для распаковки картинок)
       tcl:tcolor; //Цвет прозрачности
    end;

Добавляем на форму: Имя компонента: Название компонента: Описание

DXDIB TDXDIB - Тут изображение сжимается

dlb TDirectoryListBox - Тут выбор каталога с изображениями

flb TFileListBox - Тут список BMP файлов

dcb TDriveComboBox - Тут выбор диска с изображениями

Button1 - TButton Начало сжатия

Button2 - TButton Выход из программы

Edit1 TEdit - Тут в формате String хранится цвет прозрачности

Edit2 TEdit - Отсюда берется название изображений

Теперь на нажатие первой кнопки пишем:

     
    procedure TForm1.Button1Click(Sender: TObject);
    var
       fs:Tfilestream;
       m:Tmemorystream;
       size:int64;
       h:thead;
       i:integer;
    begin
       fs:=tfilestream.Create('what.fnt',fmCreate); //Создаем архив
       h.count:=flb.Count; //Заносим данные в заголовок файла(3 строки)
       h.name:=edit2.Text;
       h.tcl:=stringtocolor(edit1.Text);
       fs.Write(h,sizeof(h)); //Записываем заголовок
       for i:=0 to h.count-1 do //Теперь от 0 до количества изображений-1 делаем:
       begin       dxdib.DIB.LoadFromFile(flb.Items[i]); //Загружаем картинку в TDIB
          dxdib.DIB.Compress; //Сжимаем
          m:=tmemorystream.Create; //Создаем поток в памяти
          dxdib.DIB.SaveToStream(m); //Сохраняем изображение в поток
          size:=m.Size; //Получаем размер изображения в байтах
          fs.Write(size,sizeof(size)); //Записываем размер изображения в архив
          m.Position:=0; //Просто это нужно
          fs.CopyFrom(m,size); //Записываем поток изображения в файл
          m.Free; //Очищаем память от изображения
       end;
       fs.Free; //Сохраняем архив
    end;
    В игре необходимо загрузить шрифты из папки fonts процедурой: 
    procedure loadfont(name:string); //Не забудте указать название шрифта (имя файла)
    var
       item:Tpicturecollectionitem; //Изображение в памяти
       fs:Tfilestream; //Файловый поток для чтения архива
       m:Tmemorystream; //Поток в памяти (туда будет копироваться изображение)
       size:int64; //Размер изображения в архиве
       h:thead; //Заголовок архива
       i:integer; //Просто нужно для счета
    begin
       fs:=tfilestream.Create('fonts\'+changefileext(name,'.fnt'),fmOpenRead); //Открываем нужный файл
       fs.Read(h,sizeof(h)); //Читаем заголовок
       for i:=0 to h.count-1 do //От 0 до количества изображений-1 делаем:
       begin
          fs.Read(size,sizeof(size)); //Читаем размер файла
          m:=tmemorystream.Create; //Создаем поток в памяти
          m.Position:=0; //Нужно
          m.SetSize(size); //Указываем размер участка памяти (чтобы память не засорять)
          m.CopyFrom(fs,size); //Вставляем в память изображение из архива
          m.Position:=0; //Нужно
          myform.DXDIB.DIB.LoadFromStream(m); //Грузим изображение из памяты в TDIB
          item:=Tpicturecollectionitem.Create(myform.il.Items); //Добавляем в коллекцию ещё одно изображение
          item.Name:=h.name+inttostr(i); //Его имя + номер символа
          item.Transparent:=true; //Прозрачен
          item.TransparentColor:=h.tcl; //Цвет прозрачности
          item.PatternWidth:=myform.dxdib.DIB.Width; //Ширина
          item.PatternHeight:=myform.dxdib.DIB.Height; //Высота
          item.SystemMemory:=false; //Нужно
          item.Picture.Graphic:=myform.dxdib.DIB; //Указываем изображения
          item.Restore; //Принимаем изменение
          m.Free; //Очищаем память
       end;
       fs.Free; //Закрываем архив
    end;

Далее идет процедура отрисовки текста (Текст, икс, игрик, название
шрифта, по центру (1-0))

    Procedure dNt(Text:string;x,y:integer;whatfont:String; center:integer); //Процедура отрисовки букв
    var
       h:Tpicturecollectionitem;
       z:integer;
       dlina:integer;
       dlina2:integer;
    begin
       if center=1 then
       begin
          dlina2:=0;
          for z:=1 to strlen(pchar(text)) do
          begin
             h:=myform.il.Items.Find(whatfont+inttostr(ord(text[z])));
             dlina2:=dlina2+h.PatternWidth+1;
          end;
          dnt(Text,x-dlina2 div 2,y,whatfont,0);
       end
       else
       begin
          dlina:=x;
          for z:=1 to strlen(pchar(text)) do
          begin
             h:=myform.il.Items.Find(whatfont+inttostr(ord(text[z])));
             h.Draw(myform.dxdraw.Surface,dlina,y,0);
             dlina:=dlina+h.PatternWidth+1;
          end;
       end;
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
