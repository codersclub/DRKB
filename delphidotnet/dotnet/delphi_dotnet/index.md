---
Title: .NET глазами дельфийца. Использование Delphi в .NET
Date: 01.01.2007
---


.NET глазами дельфийца. Использование Delphi в .NET
===================================================

::: {.date}
01.01.2007
:::

.Net глазами дельфийца. Использование Delphi в .Net

Для программистов, рассматривающих вопрос перехода на новую систему
разработки, один из главных вопросов -- как в новой системе можно будет
использовать старые наработки.

В настоящей статье рассмотрены некоторые простые способы использования
наработок Delphi (автор использовал версию 6) в .Net. Естественно,
полностью портировать Delphi в .Net под силу только разработчикам
Borland (или аналогичным серьезным людям, владеющим к тому же полными
исходниками Delphi), поэтому здесь мы не будем рассматривать клиентские
(визуальные) приложения, использующие VCL. Тем не менее некоторый объем
функционального кода, реализованного в Delphi, может быть использован и
в .Net (пример такого кода -- вычислительные модули).

Итак, для переноса Delphi-кода в .Net можно использовать следующие
способы:

\- переписывание кода;

\- использование в .Net COM-объектов, разработанных в Delphi;

\- использование в .Net библиотек DLL, разработанных в Delphi;

\- хакерские способы

Переписывание кода

Этот способ, несмотря на его прямолинейность, в некоторых случаях может
оказаться наиболее рациональным и даже упростить результирующий код.

Техника переноса алгоритмов на другие языки знакома многим
программистам. Более того, существуют автоматические трансляторы типа
Pas2C, которые входной паскалевский код преобразуют в C/C++-код
(естественно, кое-что приходится править потом вручную, но основа
получается вполне приемлемая).

Не останавливаясь подробно на очевидных моментах ручной трансляции кода,
хотелось бы напомнить следующее:

\- поскольку в C\# нет процедур и функций вне классов, для реализации
глобальных подпрограмм целесообразно использовать специальный(-ые)
класс(ы) со статическими методами;

\- поскольку в C\# нет глобальных переменных, для их реализации
целесообразно использовать специальный(-ые) класс(ы) со статическими
полями;

\- для реализации конструкций, эквивалентных записям Delphi, можно
использовать как классы, так и структуры (struct) -- решение зависит от
объема данных, которые, возможно, будут копироваться при передаче в
качестве параметров и пр.;

\- поскольку в C\# объекты удаляются автоматически, необходимо тщательно
проанализировать последовательность создания и удаления объектов,
особенно если в Delphi-объектах в деструкторе выполнялось освобождение
ресурсов -- в таких случаях оптимальным вариантом будет или введение
соответствующих методов «закрытия», или реализация интерфейса
IDisposable.

Использование в .Net COM-объектов, разработанных в Delphi

Поскольку стандарт OLE четко определяет протокол обмена и форматы
данных, то никаких особенностей при разработке COM-объектов в Delphi нет
(не считая того, что нежелательно использовать имена методов,
совпадающие с методами класса Object из C\#: Equals, GetHashCode,
GetType, ReferenceEquals, ToString).

Если же исходный код реализован, например, в виде набора классов Delphi,
то можно написать в Delphi очень простой COM-объект (inproc-server),
который будет выполнять функции фасада (см. например Шаблоны
проектирования на www.dotsite.spb.ru ).

Кстати, во многих случаях введение «фасада» позволяет даже упростить
систему со стороны основного кода.

Использование в .Net библиотек DLL, разработанных в Delphi

Т.к. в Delphi позволяет разрабатывать динамические библиотеки DLL, то
можно существующий Delphi-код «упаковать» в библиотеку. Этот способ
заставляет выполнить несколько бОльшую работу в C\#, чем при
использовании COM-объектов, хотя в некоторых случаях вполне может быть
использован из соображений, например, быстродействия системы.

Вызов функций DLL из C\# достаточно неплохо описан в документации .Net.
Ниже приводится пример использования DLL, разработанной в Delphi.

Заголовки DLL-функций в Delphi:

    // Процедура без параметров
    procedure Proc1; stdcall;
    // Процедура с целочисленными параметрами
    procedure Proc2(A, B: integer); stdcall;
    // Процедура с вещественными параметрами
    procedure Proc3(A, B: double); stdcall;
    // Процедура с логическими параметрами
    procedure Proc4(A, B: boolean); stdcall;
    // Процедура с параметрами типа дата/время
    procedure Proc5(A, B: TDateTime); stdcall;
    // Процедура со строковыми параметрами
    procedure Proc6(P1, P2: PChar); stdcall;

Обратите внимание на два момента:

\- используется модификатор вызова stdcall

\- строки в качестве параметров передаются как PChar

    using System;
     
    using System.Runtime.InteropServices;

    namespace Test1
    {
      /// <summary>
      /// Обертка для вызова функций Delphi, размещенных в DLL
      /// </summary>
      public class LibWrap {
        /// <summary>
        /// Процедура без параметров
        /// </summary>
        [ DllImport( @"C:\Projects\C#\DelphiPortal\Dll1.dll" ) ]
        public static extern void Proc1();
        /// <summary>
        /// Процедура с целочисленными параметрами
        /// </summary>
        [ DllImport( @"C:\Projects\C#\DelphiPortal\Dll1.dll" ) ]
        public static extern void Proc2(int A, int B);
        /// <summary>
        /// Процедура с вещественными параметрами
        /// </summary>
        [ DllImport( @"C:\Projects\C#\DelphiPortal\Dll1.dll" ) ]
        public static extern void Proc3(double A, double B);
        /// <summary>
        /// Процедура с логическими параметрами
        /// </summary>
        [ DllImport( @"C:\Projects\C#\DelphiPortal\Dll1.dll" ) ]
        public static extern void Proc4(bool A, bool B);
        /// <summary>
        /// Процедура с параметрами типа дата/время
        /// </summary>
        [ DllImport( @"C:\Projects\C#\DelphiPortal\Dll1.dll" ) ]
        public static extern void Proc5(double A, double B);
        /// <summary>
        /// Процедура со строковыми параметрами
        /// </summary>
        [ DllImport( @"C:\Projects\C#\DelphiPortal\Dll1.dll" ) ]
        public static extern void Proc6(
          [MarshalAs(UnmanagedType.LPStr)] string A, 
          [MarshalAs(UnmanagedType.LPStr)] string B);
      }
      /// <summary>
      /// Тестовый класс
      /// </summary>
      class Class1 {
        [STAThread]
        static void Main() {
          // Вызов процедуры без параметров
          LibWrap.Proc1();
          /// Вызов процедуры с целочисленными параметрами
          LibWrap.Proc2(1, 2);
          // Вызов процедуры с вещественными параметрами
          LibWrap.Proc3(1.5, -2.8);
          // Вызов процедуры с логическими параметрами
          LibWrap.Proc4(true, false);
          // Вызов процедуры с параметрами типа дата/время
          DateTime dt1 = DateTime.Now;
          DateTime dt2 = dt1.AddDays(2);
          LibWrap.Proc5(dt1.ToOADate(), dt2.ToOADate());
          // Вызов процедуры со строковыми параметрами
          LibWrap.Proc6("Строка 1", "Строка 2");
        }
      }
    }

В коде C\# стОит обратить внимание на следующее:

\- при описании метода LibWrap.Proc5, работающего с параметрами типа
дата/время, типы параметров - double

\- при описании метода LibWrap.Proc6, работающего со строковыми
параметрами, необходимо в явном виде указывать способ маршализации
(атрибут MarshalAs)

\- объекты типа DateTime преобразуются в формат, понятный для Delphi, с
помощью методов ToOADate

Хакерские способы

В каталоге \<Microsoft Visual Studio
.NET\>\\FrameworkSDK\\Samples\\Technologies\\Interop\\PlatformInvoke\\Custom\\CS
имеется интересный файл - ClassMethods.cs. В этом файле показано, как
вызывать классы VC++, размещенные в DLL. Этот пример натолкнул автора
статьи на мысль проверить что-то подобное с Delphi.

Т.к. пакеты в Delphi -- не что иное, как DLL, такой вариант выглядел
возможным. Более того, с помощью утилиты Depends.Exe, входящей в состав
VSN (\<Microsoft Visual Studio .NET\>\\Common7\\Tools\\Bin), при
исследовании соответствующего BPL-файла можно даже увидеть имена
экспортируемых функций в стиле C++, например:

@\$xp\$14Class1\@TClass1

\@Class1\@TClass1@

К сожалению, автору не удалось запустить таким образом объекты \<

Взято с сайта <https://delphi.h5.ru>