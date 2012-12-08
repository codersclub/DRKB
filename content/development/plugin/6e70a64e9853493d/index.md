---
Title: Как написать свой плагин?
Date: 01.01.2007
---


Как написать свой плагин?
=========================

::: {.date}
01.01.2007
:::

Типовая задача - разрабатывается некая задача и при этом

Некоторые ее компоненты могут не инсталлироваться баз ущерба для
работоспособности

Некоторые компоненты предполагается изготавливать впоследствии и
рассылать пользователям

Некоторые компоненты могут разрабатываться другими программистами и
распространяться независимо от программы

\.....

Классические примеры - фильтры для совместимости по форматам файлов с
другими программами, некоторые расширения и дополнительные возможности.
Примеры и моей практики - приведу парочку

Программа управления программатором ПЗУ. Заранее неизвестно, с каким
железом она будет работать и как им управлять. Необходимо было дать
возможнось разработчику железа написать для него поддержку

Программа печати отчетов. Она должна печатать в любой кодировке на любой
принтере, в т.ч. и экзотическом типа АЦПУ. Заранее неизвестно, какие
принтеры будуп применяться совместно с ней и как ими управлять (известно
только одно - драйверов под них нет и не будет) - переделывать программу
под каждый принтер - неинтересно \...

Итак, все это можно реализовать в DLL, однако обычное ее подключение
приведет к тому, что при запуске программа будет искать все подключенне
к ней DLL и в случае отсутствия хотя-бы одной откажется запускаться. Это
не приемлемо, но к счастю есть возможность и весьма удоюный набор
сервисных функций для динамической загрузки, использования и выгрузки
DLL.

Пример (приложение имеет одно окно, на нем кнопка):

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls;
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        procedure Button1Click(Sender: TObject);
        procedure FormCreate(Sender: TObject);
      private
      public
      end;
     // Тип "процедура". Естественно, можно определит типы
     // "функция" или "функция с параметрами" ...
     TDllProc = procedure;
     
    var
      Form1: TForm1;
      DllProcPtr  : TDllProc;
      LibInstance : HMODULE; // Логический номер модуля DLL
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
     // Проверим, загружена ли DLL
     if LibInstance=0 then Begin
      // Не загружена, попробуем загрузить
      LibInstance := LoadLibrary('plug_in.dll');
      // Проверим, успешна ли загрузка (LibInstance=0 - неуспешно)
      If LibInstance=0 then Begin
       ShowMessage('Ошибка загрузки библиотеки plug_in.dll');
       exit;
      end;
      // Ищем функцию по ее имени (имя должно точно совпадать)
      DllProcPtr := TDllProc(GetProcAddress(LibInstance,'MyProc'));
      // Проверим, нашли ли (если нашли, то Assigned вернет true)
      if not Assigned(DllProcPtr) then Begin
       // Не нашли - выгружаем DLL из памяти
       FreeLibrary(LibInstance);
       LibInstance:=0;
       ShowMessage('Ошибка: функция MyProc не найдена');
       exit;
      end;
      // Непосредственно вызов функции
      DllProcPtr;
      // Выгрузка библиотеки
      FreeLibrary(LibInstance);
      LibInstance:=0;
     end;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
     DllProcPtr:=nil;
     LibInstance:=0;
    end;
     
    end.

Естественно, в реальной задаче имеет смысл создать свой класс, который
при инициализации будет  загружать библиотеку, а при уничтожении -
выгружать. Кроме того, он должен иметь функцию типа \"Перезагрузить
библиотеку\", которая будет выгружать текущую и загружать новую. DLL -
обычная, естественно может иметь неограниченное количество процедур и
функций.

Особенности:

Пока библиотека загружена, ее файл нельзя ни удалить, ни переименовать.
Поэтому при возникновении ошибок следует выгружать библиотеку, иначе
пользователь не сможет ее заменит (без перезагрузки ПК).

Обычно имеет смысл создать ряд функции типа GetInfo, GetAutor,
GetCopyRight \..., чтобы вызывающая программа могла получить информацию
о назначении данной DLL

Расширение DLL не является обязательным, поэтому можно применять свои
расширения (например DRV)

Источник: <https://dmitry9.nm.ru/info/>