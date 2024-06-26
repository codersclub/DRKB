---
Title: Определение номера записи в таблице dBASE
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Определение номера записи в таблице dBASE
=========================================

Таблицы dBASE применяют довольно статическую систему нумерации записей.
Номер записи для данной записи (извините за тавтологию) отражает
физическую позицию в табличном файле. Эти номера записей не изменяются
вследствие фильтрации, упорядочивания данных или сортировки. К примеру,
первая запись, хранящаяся в .DBF файле, будет иметь номер записи 1.
Возможно, после некоторого упорядочивания индекса, запись будет
последней из 100 записей. В этом случае запись должна оставаться с тем
же номером, а не номером 100, отражающим новую позицию в сортированном
наборе данных. Это противоречит таблицам Paradox, где соблюдается
последовательная нумерация. Последовательная нумерация Paradox похожа на
нумерацию записей dBASE, за исключением большей гибкости и отражению в
номере записи ее текущей позиции в наборе данных. То есть, запись может
не всегда иметь номер, установленный для нее фильтром набора данных,
уменьшившим общее число записей, или при активном индексе, из-за чего
может измениться отображаемый порядок записи.

В приложениях для работы с базами данных, созданных с помощью Delphi и
Borland Database Engine (BDE), DB-компонентами не предусмотрено
извлечение и определение записи таблицы dBASE. Такая операция, тем не
менее, возможна с помощью вызова из вашего приложения функций BDE.

Существует несколько функций BDE, возвращающих информацию о текущей
записи dBASE, например, ее номер. На самом деле, любая функция,
заполняющая структуру BDE pRECProps, вполне достаточна. Например,
функции BDE DbiGetRecord, DbiGetNextRecord и DbiGetPriorRecord.
Естественно, только первая из них реально позволяет получить информацию
о текущей записи. Две других перемещают при вводе указатель на запись,
подобно методам Next и Prior компонентов TTable и TQuery.

Структура pRECProps состоит из следующих полей:

- iSeqNum: тип LongInt; определяет текущий номер записи (относительно
набора данных, включая фильтрацию и сортировку индекса); используется,
если тип таблицы поддерживает последовательную нумерацию (только
Paradox).
- iPhyRecNum: тип LongInt; определяет номер записи; используется, если тип
таблицы поддерживает физические номера записи (только dBASE).
- bRecChanged: тип Boolean; в настоящее время не используется.
- bSeqNumChanged: тип Boolean; в настоящее время не используется.
- bDeleteFlag: тип Boolean; указывает на удаленную запись; используется,
если тип таблицы поддерживает "мягкое" удаление (только dBASE).

Одна из этих BDE-функций может быть вызвана из вашего приложения для
заполнения данной структуры, из которой затем может быть извлечен
физический номер записи. Ниже - пример использования для этой цели
функции DbiGetRecord.

    function RecNo(ATable: TTable): LongInt;
    var
      R: RECProps;
      rslt: DbiResult;
      Error: array[0..255] of Char;
    begin
      ATable.UpdateCursorPos;
      rslt := DbiGetRecord(ATable.Handle, dbiNoLock, nil, @R);
      if rslt = DBIERR_NONE then
        Result := R.iPhyRecNum
      else
      begin
        DbiGetErrorString(rslt, Error);
        ShowMessage(StrPas(Error));
        Result := -1;
      end;
    end;

Для вызова любой BDE-функции из приложения Delphi, модули-обертки BDE
DbiTypes, DbiErrs и DbiProcs должны быть включены в секцию Uses модуля,
из которого они будут вызываться (секция Uses здесь не показана). Для
того, чтобы сделать функции более транспортабельными, они не имеют
прямой ссылки на компонент TTable, но указатель на TTable передается как
параметр. Если эта функция используется в модуле, который не ссылается
на модули Delphi DB и DBTables, они должны быть добавлены, иначе ссылки
на компонент TTable будут недействительными.

Метод TTable UpdateCursorPos вызывается для гарантии синхронизации
номера текущей записи в компоненте TTable и связанной с ним таблицы.

В случае ошибок BDE функций, исключительная ситуация ими не
генерируется. Вместо этого они возвращают значение BDE-типа DbiResult,
указывающее на успешное завершение или ошибку операции. Возвращаемое
значение должно быть получено и обработано внешним приложением, с
выполнением соответствующих действий. Любой результат, кроме
DBIERR\_NONE, указывает на неудачное выполнение функции. В этом случае
может быть осуществлено дополнительное действие (как в примере выше),
где с помощью BDE функции DbiGetErrorString код ошибки переводится в
удобночитаемое сообщение. В этом примере возвращаемое в DbiGetRecord
значение сохраняется в переменной rslt, а затем для определения
успешности вызова функции сравнивается с DBIERR\_NONE.

Если вызов DbiGetRecord был успешным, физический номер записи из поля
iPhyRecNum структуры pRECProps сохраняется в переменной Result, которая
является возвращаемой функцией величиной. Чтобы указать на то, что
функция потерпела неудачу (т.е., вызов фунции DbiGetRecord окончился
неудачно), вместо номера записи возвращается отрицательная величина.
Значение ее может быть произвольным (отрицательная величина совместимого
типа) и отдается на усмотрение программисту.

