---
Title: Работа с JPEG изображением в Delphi
Author: Михаил Христосенко
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Работа с JPEG изображением в Delphi
===================================

Меня очень часто спрашивают как можно вставить изображение в формате
Jpeg в исполняемый модуль или как можно просматривать jpeg-изображения в
программе. В этой статье я попробую рассказать и показать на примерах
как можно работать со jpeg-изображениями.

Для этих целей в Дельфи предусмотрено два класса TJpegImage и TJpegData.
Мы будем использовать первый, он описан в модуле JPEG (его надо
подключить в uses).

Теперь попробуем реализовать такую вещь. Сделаем конвертер картинок в
формате \*.bmp в формат \*.jpeg. Для этого нам понадобится такие
компоненты: TImage (для просмотра картинок), две кнопки TButton (для
открытия диалога выбора картинок и для запуска процесса), TTrackBar (для
того чтобы устанавливать качество картинки), TCheckBox (чтобы
устанавливать или убирать флаг "Оттенки серого") и TOpenDialog.

Обработчик события OnClick для первой кнопки может иметь такой вид:

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      if opendialog1.execute then
        image1.Picture.LoadFromFile(opendialog1.filename);
    end;

Кстати не забудьте настроить фильтр для OpenDialog1, чтобы можно было
открывать только картинки в формате \*.bmp.

Теперь непосредственно займемся написанием основной части программы, то
есть создание jpeg-изображения. Все действия будем производить по щелчку
на второй кнопке. Нам необходимо будет создать объект типа TJpegImage,
провести с ним необходимые действия, а потом с помощью метода Compress,
упаковать изображение и остается только сохранить изображение в файл.
Еще необходимо настроить свойства TrackBar\'a: свойство Max надо сделать
равным 100 и свойство Position равным также 100. Итак, обработчик
нажатия на вторую кнопку может быть таким:

    procedure TForm1.Button2Click(Sender: TObject);
    var
      jpg: TJpegImage;
    begin
      {создаем экземпляр объекта}
      jpg := TJpegImage.Create;
      {присваиваем ему изображение}
      jpg.Assign(image1.picture.graphic);
      {устанавливаем степень сжатия (качество) 1..100}
      jpg.CompressionQuality := TrackBar1.Position;
      {если установлен флаг "Оттенки серого", то пусть картинка будет серой:)}
      jpg.Grayscale := checkbox1.Checked;
      {Упаковываем графику}
      jpg.Compress;
      {и сохраняем ее куда вам захочется}
      jpg.SaveToFile('D:\first.jpg');
      {уничтожаем экземпляр объекта}
      jpg.free;
    end;

Как вы видите все очень просто! На всякий случай приведу полный код
приложения:

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      ComCtrls, ExtCtrls, StdCtrls, JPEG;
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        Button2: TButton;
        Image1: TImage;
        TrackBar1: TTrackBar;
        OpenDialog1: TOpenDialog;
        CheckBox1: TCheckBox;
        procedure Button1Click(Sender: TObject);
        procedure Button2Click(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      if opendialog1.execute then
        image1.Picture.LoadFromFile(opendialog1.filename);
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    var
      jpg: TJpegImage;
    begin
      {создаем экземпляр объекта}
      jpg := TJpegImage.Create;
      {присваиваем ему изображение}
      jpg.Assign(image1.picture.graphic);
      {устанавливаем степень сжатия (качество) 1..100}
      jpg.CompressionQuality := TrackBar1.Position;
      {если установлен флаг "Оттенки серого", то пусть картинка будет серой:)}
      jpg.Grayscale := checkbox1.Checked;
      {Упаковываем графику}
      jpg.Compress;
      {и сохраняем ее куда вам захочется}
      jpg.SaveToFile('D:\first.jpg');
      {уничтожаем экземпляр объекта}
      jpg.free;
    end;
     
    end.

Для обратного преобразования из Jpg в Bmp необходимо воспользоваться
методом `DibNeeded`.


