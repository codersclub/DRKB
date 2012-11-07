<h1>Файловые операции</h1>
<div class="date">01.01.2007</div>


<p>Дельфи предоставляет довольно широкие возможности по файловым операциям без использования механизмов открытия/закрытия файлов.</p>
<p>Вот список наиболее употребимых функций, большинство из которых в фачкстве параметров нуждаются только в имени файла:</p>
<p>ChDir(NewCurrentPath: string); - изменяет текущий каталог (в среде Windows сие конечно не так актуально как в ДОС, но все же), прочитать же текущий каталог можно функцией GetCurrentDir, а текущий каталог для определенного драйва - GetDir.</p>
<p>CreateDir(const Dir: string): Boolean; - создает каталог. При этом предыдущий уровень должен присутствовать. Если вы хотите сразу создать всю вложенность каталогов используйте функцию ForceDirectories(Dir: string): Boolean; Обе функции возвращают True если каталог создан</p>
<p>DiskFree(Drive: Byte): Int64; - дает свободное место на диске. Параметер - номер диска 0 = текущий, 1 = A, 2 = B, и так далее</p>
<p>DiskSize(Drive: Byte): Int64; - размер винта. Обратите внимание на то что для результата этой и предыдущей функций абсолютно необходимо использовать переменную типа Int64, иначе макимум того что вы сможете прочитать правильно будет ограничен 2Gb</p>
<p>FileExists(const FileName: string) - применяется для проверки наличия файла</p>
<p>FileGetAttr(const FileName: string): Integer;</p>
<p>FileSetAttr(const FileName: string; Attr: Integer): Integer; - функции для работы с атрибутами файлов. Вот список возможных атрибутов:</p>
<p>faReadOnly        $00000001        Read-only files</p>
<p>faHidden        $00000002        Hidden files</p>
<p>faSysFile        $00000004        System files</p>
<p>faVolumeID        $00000008        Volume ID files</p>
<p>faDirectory        $00000010        Directory files</p>
<p>faArchive        $00000020        Archive files</p>
<p>faAnyFile        $0000003F        Any file</p>
<p>(Естественно не все атрибуты применимы во всех случаях)</p>
<p>RemoveDir(const Dir: string): Boolean; - удаляет папку(пустую)</p>
<p>DeleteFile(const FileName: string): Boolean; - удаляет файл</p>
<p>RenameFile(const OldName, NewName: string) - переименовывает файл</p>

