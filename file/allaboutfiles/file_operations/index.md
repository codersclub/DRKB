---
Title: Файловые операции
Date: 01.01.2007
---


Файловые операции
=================

::: {.date}
01.01.2007
:::

Дельфи предоставляет довольно широкие возможности по файловым операциям
без использования механизмов открытия/закрытия файлов.

Вот список наиболее употребимых функций, большинство из которых в
фачкстве параметров нуждаются только в имени файла:

ChDir(NewCurrentPath: string); - изменяет текущий каталог (в среде
Windows сие конечно не так актуально как в ДОС, но все же), прочитать же
текущий каталог можно функцией GetCurrentDir, а текущий каталог для
определенного драйва - GetDir.

CreateDir(const Dir: string): Boolean; - создает каталог. При этом
предыдущий уровень должен присутствовать. Если вы хотите сразу создать
всю вложенность каталогов используйте функцию ForceDirectories(Dir: string): Boolean;

Обе функции возвращают True если каталог создан

DiskFree(Drive: Byte): Int64; - дает свободное место на диске.
Параметер Drive - номер диска: 0 = текущий, 1 = A, 2 = B, и так далее.

DiskSize(Drive: Byte): Int64; - размер винта. Обратите внимание на то
что для результата этой и предыдущей функций абсолютно необходимо
использовать переменную типа Int64, иначе максимум того что вы сможете
прочитать правильно будет ограничен 2Gb.

FileExists(const FileName: string) - применяется для проверки наличия файла.

FileGetAttr(const FileName: string): Integer;

FileSetAttr(const FileName: string; Attr: Integer): Integer; - функции
для работы с атрибутами файлов.

Вот список возможных атрибутов:

    faReadOnly   $00000001  Read-only files

    faHidden     $00000002  Hidden files

    faSysFile    $00000004  System files

    faVolumeID   $00000008  Volume ID files

    faDirectory  $00000010  Directory files

    faArchive    $00000020  Archive files

    faAnyFile    $0000003F  Any file

(Естественно не все атрибуты применимы во всех случаях)

RemoveDir(const Dir: string): Boolean; - удаляет папку (пустую).

DeleteFile(const FileName: string): Boolean; - удаляет файл.

RenameFile(const OldName, NewName: string) - переименовывает файл.
