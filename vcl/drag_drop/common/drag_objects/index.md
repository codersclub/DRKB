---
Title: Перетаскивание объектов
Author: Павел
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Перетаскивание объектов
=======================

Свойства DragMode, DragCursor, методы BeginDrag, OnDragOver, OnDragDrop,
OnEndDrag, OnStartDrag, параметр Accept

Процесс перетаскивания с помощью мыши информации из одного объекта в
другой широко используется в Widows.Можно перемещать файлы между
папками, перемещать сами папки и др.

Все свойства, методы и события, связанные с процессом перетаскивания,
определены в классе TControl, являющегося прародителем всех визуальных
компонентов Delphi. Поэтому они являются общими для всех компонентов.

Начало перетаскивания определяется свойством DragMode, которое может
устанавливаться в процессе проектирования или программно равным dmManual
или dmAutomatic. Значение dmAutomatic (автоматическое) определяет
автоматическое начало процесса перетаскивания при нажатии пользователем
кнопки мыши над компонентом. Однако в этом случае событие OnMouseDown,
связанное с нажатием пользователем кнопки мыши, для этого компонента
вообще не наступает.

Значение dmManual (ручное) говорит о том, что начало процесса
перетаскивания должен определить программист. Для этого он должен в
соответствующий момент вызвать метод BeginDrag. Например, он может
поместить вызов этой функции в обработчик события OnMouseDown,
наступающего в момент нажатия кнопки мыши. В этом обработчике он может
проверить предварительно какие-то условия (режим работы приложения,
нажатие тех или иных кнопок мыши и вспомогательнх клавиш) и при
выполнении этих условий вызвать BeginDrag.

Пусть, например, процесс перетаскавания должен начаться, если
пользователь нажал левую кнопку мыши и клавишу Alt над списком ListBox1.
Тогда свойство DragMode этого компонента надо установить в dmManual, а
его обработчик события OnMouseDown может иметь вид:

    procedure TForm1.ListBox1MouseDown(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
    begin
      if (Button = mbLeft) and (ssAlt in Shift) then
        (Sender as TControl).BeginDrag(false);
    end;

Параметр Button обработчика события OnMouseDown показывает, какая кнопка
мыши была нажата, а параметр Shift является множеством, содержащим
обозначения нажатых в этот момент кнопок мыши и вспомогательных клавиш
клавиатуры. Если нажата левая кнопка мыши и клавиша Alt, то вызывается
метод BeginDrag данного компонента.

В функцию BeginDrag передано значение False. Это означает, чтопроцесс
перетаскивания начнется не сразу, а только после того, как пользователь
сдвинет мышь с нажатой при этом кнопкой. Это позволяет отличить простой
щелчок мыши от начала перетаскивания. Если же передать в BeginDrag
значение True, то перетаскивание начнется немедленно.

Когда начался процесс перетаскивания, обычный вид курсора изменяется.
Пока он перемещается над формой или компонентами, которые не могут
принять информацию, он обычно имеет вид crNoDrop . Если же он
перемещается над компонентом, готовым принять информацию из
перетаскиваемого объекта, то приобретает вид, определяемый свойством
перетаскиваемого объекта DragCursor. По умолчанию это свойство равно
crDrag, что соответствует изображению . Вид курсора определяется
свойством DragCursor перетаскиваемого объекта, а не того объекта, над
которым перемещается курсор.

В процессе перетаскивания компоненты, над которыми перемещаетяс курсор,
могут информировать о готовности принятьинформацию от перетаскиваемого
объекта. Для этого в компоненте должен быть предусмотрен обработчик
события OnDragOver, наступающего при перемещении над данным компонентом
курсора, перетаскивающего некоторый объект. В этом обработчике надо
проверить, может ли данный компонент принять информацию перетаскиваемого
объекта, и, если не может, задать значение False передаваемому в
обработчик параметру Accept. По умолчанию этот параметр равен True, что
означает возможность принять перетаскиваемый объект. Обработчик для
списка может иметь, например, следующий вид:

    procedure TForm1.ListBox1DragOver(Sender, Source: TObject;
      X, Y: Integer; State: TDragState; var Accept: Boolean);
    begin
      if (Sender as TControl <> Source) then
        Accept := Source is TListBox
      else
        Accept := False;
    end;

В нем сначала проверяется, не является ли данный компонент (Sender) и
перетаскиваемый объект (Source) одним и тем же объектом. Это сделано,
чтобы избежать перетаскивания информации внутри одного и того же списка.

Значение параметра Accept, задаваемое в обрапботчике события onDragOver,
определяет вид курсора, перемещающегося при перетаскивании над данным
компонентом. Этот вид показывает пользователю, может ли данный компонент
принять перетаскиваемую информацию. Если в компоненте не описан
обработчик события onDragOver, то считается, что данный компонент, не
может принять информацию перетаскиваемого объекта.

Процедура приема информации от перетаскиваемого объекта записывается в
обработчике события OnDragDrop принимающего компонента. Это событие
наступает, если после перетаскивания пользовательотпустил клавишу мыши
над данным компонентом. В обработчик этого события передаются параметры
Source (объект-источник) и X и Y координаты курсора. Если продолжить
пример перетаскивания информации из одного списка в другой, то
обработчик события OnDragDrop может иметь вид:

    procedure TForm1.ListBox1DragDrop(Sender, Source: TObject; X, Y: Integer);
    begin
      (Sender as TListBox).Items.Add((Source as TListBox).
        Items[(Source as TListBox).ItemIndex]);
    end;

В этом обработчике сторка, выделенная в списке-источнике (Source as
TListBox).Items[(Source as TListBox).ItemIndex], добавляется в
список-приемник методом (Sender as TListBox).Items.Add. Используется
операция AS, позволяющая расссматривать параметры Sender и Source как
указатели на объект класса TListBox. Это делается потому, что эти
параметры объявлен в заголовке процедуры как указатели на объекты класса
TObject. Но в классе TObject нет свойств Items и ItemIndex, которые нам
требуются. Эти свойства определены в классе TListBox, являющемся
наследником TObject. Поэтому с параметрами Sender и Source в данном
случае надо оперировать как с указателями на объекты TListBox, что и
выполняет операция as.

В данном случае можно было бы не использовать параметр Sender, заменив
(Sender as TListBox) просто на ListBox1. Но запись оператора в общем
виде с помощью параметра Sender позволяет воспользоваться таким
обработчиком и для других компонентов ListBox, если они имеются в
приложении.

После завершения или прерывания перетаскивания наступает событие
OnEndDrag, в обработчике которого можно предусмотреть какое-то
дополнительное действие. Имеется также связанное с перетаскиванием
событие OnStartDrag, которое позволяет произвести какие-то операции в
начале перетаскивания, когда иным способом этот момент нельзя
зафиксировать.

Таким образом, если в приложении имеется несколько списков и нужно
задать возможность копирования строк каждого из этих списков в любой
другой, то это потребует двух операций:

Написать для одного списка обработчик события onDragOver. Для всех
остальных списков сослаться в событиях onDragOver на этот же обработчик
(выделив в форме все оставшиеся списки).

Написать аналогичным образом для всех списков обработчик события
OnDragDrop.

Если начинать перетаскивание нужно только при выполнении какого-то
дополнительног условия, например, при нажатии клавиши Alt, то
потребуется:

Задать для всех списков значение свойства DragMode, равное dmManual и
написать обработчик события OnMouseDown.

В приведенном ниже примере:

Многострочный редактор Memo1 готов принять информацию от TLabel и
TListBox; списки ListBox готовы принять информацию от всех других
списков и при этом, если информация передается не от списка ListBox2, то
их списка-источника она удаляется (переносится). Из списка ListBox2
информация только копируется. для метки Label1 c заголовком dmAutomatic
определено событие OnEndDrag так, что выводится сообщение об успешном
или неуспешном завершении процесса переноса, которое выводится в случае
включения флажка с заголовком \<Сообщения\> :

    procedure TForm1.Label1EndDrag(Sender, Target: TObject; X, Y: Integer);
    begin
      if CheckBox1.Checked then
        if Target = nil then
          ShowMessage('Перенесение объекта ' + (Sender as TControl).Name +
            ' прервано')
        else
          ShowMessage((Sender as TControl).Name + ' перенесена в ' +
            (Target as TControl).Name);
    end;

для списков ListBox3 и ListBox4 перетаскивание возможно только при
нажатой клавише Alt, но для ListBox4 перетаскивание начинается сразу
(значение функции BeginDrag(true)), а для ListBox3 (и метки Label1)
момент перетаскивания определяется началом движения мышки (значение
функции BeginDrag(false)).

    unit Udrag1;
    interface
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls,
      Forms, Dialogs, StdCtrls;
    type
      TForm1 = class(TForm)
        Memo1: TMemo;
        Label1: TLabel;
        Label2: TLabel;
        Label3: TLabel;
        ListBox1: TListBox;
        ListBox2: TListBox;
        ListBox3: TListBox;
        ListBox4: TListBox;
        Label4: TLabel;
        CheckBox1: TCheckBox;
        procedure Memo1DragOver(Sender, Source: TObject; X, Y: Integer;
          State: TDragState; var Accept: Boolean);
        procedure Memo1DragDrop(Sender, Source: TObject; X, Y: Integer);
        procedure ListBox1DragOver(Sender, Source: TObject; X, Y: Integer;
          State: TDragState; var Accept: Boolean);
        procedure ListBox1DragDrop(Sender, Source: TObject; X, Y: Integer);
        procedure ListBox3MouseDown(Sender: TObject; Button: TMouseButton;
          Shift: TShiftState; X, Y: Integer);
        procedure Label1EndDrag(Sender, Target: TObject; X, Y: Integer);
        procedure ListBox4MouseDown(Sender: TObject; Button: TMouseButton;
          Shift: TShiftState; X, Y: Integer);
      private { Private declarations }
      public { Public declarations }
      end;
     
    var
      Form1: TForm1;
    implementation{$R *.DFM}
     
    procedure TForm1.Memo1DragOver(Sender, Source: TObject; X, Y: Integer;
      State: TDragState; var Accept: Boolean);
    begin
      Accept := (Source is TLabel) or (Source is TListBox);
    end;
     
    procedure TForm1.Memo1DragDrop(Sender, Source: TObject; X, Y: Integer);
    begin
      if (Source.ClassName = 'TLabel') then
        Memo1.Lines.Add((Source as TLabel).Caption)
      else
        Memo1.Lines.Add((Source as TListBox).
          Items[(Source as TListBox).ItemIndex]);
      ;
    end;
     
    procedure TForm1.ListBox1DragOver(Sender, Source: TObject; X, Y: Integer;
      State: TDragState; var Accept: Boolean);
    begin
      if (Sender <> Source) then
        Accept := Source is TListBox
      else
        Accept := False;
    end;
     
    procedure TForm1.ListBox1DragDrop(Sender, Source: TObject; X, Y: Integer);
    begin
      (Sender as TListBox).Items.Add((Source as TListBox).
        Items[(Source as TListBox).ItemIndex]);
      if (Source as TListBox).Name <> 'ListBox2' then
        (Source as TListBox).Items.Delete((Source as TListBox).ItemIndex);
    end;
     
    procedure TForm1.ListBox3MouseDown(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
    begin
      if (Button = mbLeft) and (ssAlt in Shift) then
        (Sender as TControl).BeginDrag(false);
    end;
     
    procedure TForm1.Label1EndDrag(Sender, Target: TObject; X, Y: Integer);
    begin
      if CheckBox1.Checked then
        if Target = nil then
          ShowMessage('Перенесение объекта ' + (Sender as TControl).Name +
            ' прервано')
        else
          ShowMessage((Sender as TControl).Name + ' перенесена в ' +
            (Target as TControl).Name);
    end;
     
    procedure TForm1.ListBox4MouseDown(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
    begin
      if (Button = mbLeft) and (ssAlt in Shift) then
        (Sender as TListBox).BeginDrag(true);
    end;
    end.


