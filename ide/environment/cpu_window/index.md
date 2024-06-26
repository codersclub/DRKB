---
Title: Активизация и использование в IDE окна CPU
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Активизация и использование в IDE окна CPU
==========================================

**Предупреждение:**  
Окно CPU еще до конца не оттестировано и может иногда
приводить к ошибкам. Если у вас есть проблемы с отладчиком, или при
запуске вашей программы вы не можете им воспользоваться, окно CPU может
помочь решить ваши проблемы. Обычно его не требуется включать, если
только у вас не "особый случай".

В Delphi 2 эта характеристика встроена, но по умолчанию выключена,
называется это окно CPU window, или DisassemblyView. Она легка в
использовании, может быть полезной в отладке и сравнении кода при его
оптимизации.

Для активизации этой характеристики, запустите REGEDIT и отредактируйте
регистры описанным ниже образом. Найдите ключ
HKEY\_CURRENT\_USER\\Software\\Borland\\Delphi\\2.0\\Debugging. Создайте
по этому пути строковый ключ с именем "ENABLECPU". Значение нового
ключа должно быть строкой "1". Это все. Теперь в Delphi IDE появился
новый пункт меню View\|CPUWindow. При его активизации выводится новое
окно.

Теперь, чтобы понять какое мощное средство оказалось в ваших руках,
сделаем сравнительный анализ генерируемого кода для двух примеров,
имеющих одинаковую функциональность, но достигающую ее разными путями.

Создайте 2 одинаковых обработчика события. В каждом обработчике события
разместите приведенный ниже код. Установите точку прерывания на первой
строчке каждого обработчика. Запустите приложение и активизируйте
события. Сравните ассемблерный код обоих методов. Один короче? В этом
случае он будет исполняться быстрее.

Достойными для такого рода анализа могут быть участки кода, многократно
выполняемые в процессе работы программы, или критические ко времени
выполнения.

Хорошим примером, где различный код выполняет одну и ту же работу, но
делает это с разной скоростью, является использование конструкции "with
object do". Исходный код с многократным использованием конструкции
"with object do" будет длиннее, но ассемблерный код короче. Вспомните,
сколько раз вы устанавливали свойства для динамически создаваемых
объектов? Код:

    with TObject.create do
    begin
      property1 := ;
      property2 := ;
      property3 := ;
    end;

будет выполняться быстрее, чем

    MyObj := TObject.create;
    MyObj.Property1 := ;
    MyObj.Property2 := ;
    MyObj.Property3 := ;

