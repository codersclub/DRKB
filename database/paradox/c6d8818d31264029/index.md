---
Title: Каскадированное удаление с проверкой целостности Paradox
Date: 01.01.2007
---


Каскадированное удаление с проверкой целостности Paradox
========================================================

::: {.date}
01.01.2007
:::

Таблицы Paradox имеют характеристику проверки целостности (Referential
Integrity). Данная характеристика предотвращает добавление записей в
дочернюю таблицу, для которых нет соответствующих записей в родительской
таблице. Это также изменяет ключевое(ые) поле(я) в дочерней таблице при
изменениях в соответствующем(их) ключевом(ых) поле(ях) родительской
таблицы (обычно это называют каскадированным обновлением). Эти события
происходят автоматически, и не требуют никакого вмешательства со стороны
Delphi-приложений, использующих эти таблицы. Тем не менее,
характеристика проверки целостности таблиц Paradox не работает с
каскадированным удалением. То есть, Delphi не позволит вам удалять
записи в родительской таблице при наличии существующих записей в
дочерней таблице. Это могут сделать только дочерние записи \"без
родителей\", обходя проверку целостности. При попытке удаления такой
родительской записи, Delphi сгенерит объект исключительной ситуации.

Для того, чтобы каскадированное удаление дало эффект, требуется
программное удаление соответствующих дочерних записей прежде, чем будет
удалена родительская запись. В приложениях Delphi это делается
посредством прерывания удаления записи в родительской таблице, удаление
соответствующих записей в дочерней таблице (если таковая имеется), и
затем продолжение удаления родительской записи.

Удаление записи таблицы осуществляется вызовом метода Delete компонента
TTable, который удаляет текущую запись в связанной с компонентом
таблице. Прерывание процесса удаления для выполнения других операций
связано с созданием обработчика события BeforeDelete компонента TTable.
Любые действия в обработчике события BeforeDelete произойдут прежде, чем
приложением будет послана команда Borland Database Engine (BDE) на
физическое удаление записи из табличного файла.

Для того, чтобы обработать удаление одной или более дочерних записей, в
обработчике события BeforeDelete необходимо организовать цикл,
осуществляющий вызов метода Delete компонента TTable для всех записей
дочерней таблицы. Цикл основан на условии, что указатель на запись в
таблице не позиционируется на конец набора данных, как указано методом
Eof компонента TTable. Это также предполагает, что удаляются все
дочерние записи, соответствующие родительским записям: если нет
соответствующих записей, указатель на запись устанавливается на конец
набора данных, условие выполнения цикла равно False, и метод Delete в
теле цикла никогда не выполняется.

    procedure TForm1.Table1BeforeDelete(DataSet: TDataset);
    begin
      with Table2 do
      begin
        DisableControls;
        First;
        while not Eof do
          Delete;
        EnableControls;
      end;
    end;

В вышеуказанном примере родительская таблица представлена компонентом
TTable с именем Table1, и дочерняя таблица с именем Table2. Методы
DisableControls и EnableControls использованы в \"косметических\" целях,
чтобы \"заморозить\" любые компоненты для работы с базами данных,
которые могли бы отображать данные из таблицы Table2 во время удаления
записей. Эти два метода делают процесс визуально \"гладким\", и не
являются обязательными. Метод Next в теле данного цикла вызываться не
должен. Дело в том, что цикл начинается с первой записи и, так как
каждая запись удаляется, запись, предшествующая удаленной, перемещается
в наборе данных вверх, становясь одновременно первой и текущей записью.

Данный пример предполагает, что родительская и дочерняя таблицы связаны
отношением Мастер-Деталь, типичным для таблиц, в которых
сконфигурирована проверка целостности. В результате, в связанных
таблицах становятся доступны только те записи дочерней таблицы, которые
соответствуют текущей записи родительской таблицы. Все другие записи в
дочерней таблице делаются недоступными через фильтрацию Мастер-Деталь.
Если таблицы не связаны отношениями Мастер-Деталь, то есть два
дополнительных замечания, которые необходимо принимать во внимание при
удалении записи дочерней таблицы. Первое: вызов метода First может и не
переместить указатель записи в запись, соответствующей текущей записи
родительской таблицы. Для этого необходимо воспользоваться методом
search, вручную перемещающий указатель на сопоставимую запись. Второе
замечание относится к условию цикла. Поскольку будут доступны другие
записи, не относящиеся к записям родительской таблицы, сопоставимым
(Мастер-Деталь) к текущей записи, то перед удалением записи необходимо
осуществлять проверку на сопоставимость удаляемой записи. Эта проверка
должна проводиться дополнительно к методу Eof. Поскольку записи будут
сортироваться по ключевому полю (первичного или вторичного индекса), все
сопоставления (Мастер-Деталь) будут непрерывными. Это будет истиной до
достижения первой не-сопоставимой записи, после чего можно считать, что
все сопоставимые записи были удалены. Таким образом, предыдущий пример
необходимо изменить следующим образом:

    procedure TForm1.Table1BeforeDelete(DataSet: TDataset);
    begin
      with Table2 do
      begin
        DisableControls;
        FindKey([Table1.Fields[0].AsString])
        while (Fields[0].AsStrring = Table1.Fields[0].AsString)
        and (not Eof) do
          Delete;
        EnableControls;
      end;
    end;

В приведенном выше примере - первое поле родительской таблицы (Table1),
на которой базируется проверка целостности, и первое поле дочерней
таблицы (Table2), с которым производится сопоставление

Взято с <https://delphiworld.narod.ru>