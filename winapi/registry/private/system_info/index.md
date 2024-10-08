---
Title: Получаем из реестра количество активных потоков, загруженность процессора и т.д.
Author: Vimil Saju
Date: 01.01.2007
---

Получаем из реестра количество активных потоков, загруженность процессора и т.д.
================================================================================

В реестре есть раздел HKEY\_DYN\_DATA. Основная информация о системе
хранится в ключе PerfStats.

О получении информации,например, о загруженности процессора, необходимо
проделать следующие шаги:

Для начала необходимо запустить установленный счётчик в реестре. Это
возможно путём считывания значения ключа, отвечающего за нужный параметр
системы.

Например

Просто считываем значение ключа
\'PerfStats\\StartStat\\KERNEL\\CPUusage\' в секции HKEY\_DYN\_DATA.
данное действие запускает счётчик.

После этого в ключе
\'PerfStats\\StatData\\KERNEL\\CPUusage\' будет храниться значение в
процентах о загруженности процессора.

Далее, если добавить считывание загруженности процессора в событие
`On timer`, то мы сможем наблюдать изменение загруженности процессора в
динамике.

По завершении, Ваша программа должна остановить счётчик в реестре. Для
этого просто считай ключ \'PerfStats\\StopStat\\KERNEL\\CPUusage\'.
Это остановит счётчик.

Также в системе есть много других счётчиков. Весь список счётчиков
можно посмотреть в ключе PerfStats\\StatData, используя редактор
реестра.

Представленный ниже исходник получает значения всех счётчиков,
расположенных в секции HKEY\_DYN\_DATA.

    unit SystemInfo;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs,extctrls;
     
    //Информация о Dialup адаптере
    type TDialupAdapterInfo = record
      alignment:dword;
      buffer:dword;
      bytesrecieved:dword;
      bytesXmit:dword;
      ConnectSpeed:dword;
      CRC:dword;
      framesrecieved:dword;
      FramesXmit:dword;
      Framing:dword;
      runts:dword;
      Overrun:dword;
      timeout:dword;
      totalbytesrecieved:dword;
      totalbytesXmit:dword;
    end;
     
    type TKernelInfo = record
      CpuUsagePcnt:dword;
      Numthreads:dword;
      NumVMS:dword;
    end;
     
    type TVCACHEInfo = record
      ccurpages:dword;
      cMacPages:dword;
      cminpages:dword;
      FailedRecycles:dword;
      Hits:dword;
      LRUBuffers:dword;
      LRURecycles:dword;
      Misses:dword;
      RandomRecycles:dword;
    end;
     
    type TFATInfo = record
      BreadsSec:dword;
      BwritesSec:dword;
      Dirtydata:dword;
      ReadsSec:dword;
      WritesSec:dword;
    end;
     
    type TVMMInfo = record
      CDiscards:dword;
      CInstancefaults:dword;
      CPageFaults:dword;
      cPageIns:dword;
      cPageOuts:dword;
      cpgCommit:dword;
      cpgDiskCache:dword;
      cpgDiskCacheMac:dword;
      cpgDiskCacheMid:dword;
      cpgDiskCacheMin:dword;
      cpgfree:dword;
     
      cpglocked:dword;
      cpglockedNoncache:dword;
      cpgother:dword;
      cpgsharedpages:dword;
      cpgswap:dword;
      cpgswapfile:dword;
      cpgswapfiledefective:dword;
      cpgswapfileinuse:dword;
    end;
     
    type
      TSysInfo = class(TComponent)
      private
        fDialupAdapterInfo:TDialupAdapterInfo;
        fKernelInfo:TKernelInfo;
        fVCACHEInfo:TVCACHEInfo;
        fFATInfo:TFATInfo;
        fVMMInfo:TVMMInfo;
        ftimer:TTimer;
        fupdateinterval:integer;
        tmp:dword;
        vsize:dword;
        pkey:hkey;
        regtype:pdword;
        fstopped:boolean;
        procedure fupdatinginfo(sender:tobject);
        procedure fsetupdateinterval(aupdateinterval:integer);
      protected
        fsysInfoChanged:TNotifyEvent;
      public
        constructor Create(Aowner:Tcomponent);override;
        destructor Destroy;override;
     
        property DialupAdapterInfo: TDialupAdapterInfo read fDialupAdapterInfo;
        property KernelInfo: TKernelInfo read fKernelInfo;
        property VCACHEInfo: TVCACHEInfo read fVCACHEInfo;
        property FATInfo: TFATInfo read fFATInfo;
        property VMMInfo: TVMMInfo read fVMMInfo;
        procedure StartRecievingInfo;
        procedure StopRecievingInfo;
      published
        property SysInfoChanged:TNotifyEvent read fsysInfoChanged write
        fsysInfoChanged;//Это событие вызывается после определённого интервала времени.
        property UpdateInterval:integer read fupdateInterval write
        fsetupdateinterval default 5000;
    end;
     
    procedure register;
     
    implementation
     
    constructor TSysInfo.Create(Aowner:Tcomponent);
    begin
      inherited;
      ftimer:=ttimer.Create(self);
      ftimer.enabled:=false;
      ftimer.OnTimer:=fupdatinginfo;
      vsize:=4;
      fstopped:=true;
    end;
     
    procedure TSysInfo.startrecievingInfo;
    var
      res:integer;
    begin
      res:=RegOpenKeyEx(HKEY_DYN_DATA, 'PerfStats\StartStat',0,KEY_ALL_ACCESS,pkey);
      if res<>0 then
        raise exception.Create('Could not open registry key');
      fstopped:=false;
      // Для Dial Up Адаптера
      RegQueryValueEx(pkey,'Dial-Up Adapter\Alignment',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'Dial-Up Adapter\Buffer',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'Dial-Up Adapter\Framing',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'Dial-Up Adapter\Overrun ',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'Dial-Up Adapter\Timeout',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'Dial-Up Adapter\CRC',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'Dial-Up Adapter\Runts',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'Dial-Up Adapter\FramesXmit',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'Dial-Up Adapter\FramesRecvd',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'Dial-Up Adapter\BytesXmit',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'Dial-Up Adapter\BytesRecvd',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'Dial-Up Adapter\TotalBytesXmit',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'Dial-Up Adapter\TotalBytesRecvd',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'Dial-Up Adapter\ConnectSpeed',nil,regtype,@tmp,@vsize);
     
      // Для VCACHE
      RegQueryValueEx(pkey,'VCACHE\LRUBuffers',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'VCACHE\FailedRecycles',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'VCACHE\RandomRecycles',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'VCACHE\LRURecycles',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'VCACHE\Misses',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'VCACHE\Hits',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'VCACHE\cMacPages',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'VCACHE\cMinPages',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'VCACHE\cCurPages',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'Dial-Up Adapter\BytesXmit',nil,regtype,@tmp,@vsize);
     
      //Для VFAT
     
      RegQueryValueEx(pkey,'VFAT\DirtyData',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'VFAT\BReadsSec',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'VFAT\BWritesSec',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'VFAT\ReadsSec',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'VFAT\WritesSec',nil,regtype,@tmp,@vsize);
      //Для VMM
     
      RegQueryValueEx(pkey,'VMM\cpgLockedNoncache',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'VMM\cpgCommit',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'VMM\cpgSharedPages',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'VMM\cpgDiskcacheMid',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'VMM\cpgDiskcacheMac',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'VMM\cpgDiskcacheMin',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'VMM\cpgDiskcache',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'VMM\cpgSwapfileDefective',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'VMM\cpgSwapfileInUse',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'VMM\cpgSwapfile',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'VMM\cDiscards',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'VMM\cPageOuts',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'VMM\cPageIns',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'VMM\cInstanceFaults',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'VMM\cPageFaults',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'VMM\cpgOther',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'VMM\cpgSwap',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'VMM\cpgLocked',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'VMM\cpgFree',nil,regtype,@tmp,@vsize);
      //Для KERNEL
      RegQueryValueEx(pkey,'KERNEL\CPUUsage',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'KERNEL\VMs',nil,regtype,@tmp,@vsize);
      RegQueryValueEx(pkey,'KERNEL\Threads',nil,regtype,@tmp,@vsize);
      RegCloseKey(pkey);
      ftimer.enabled:=true;
    end;
     
    procedure tsysinfo.fupdatinginfo(sender:tobject);
    var
      res:integer;
    begin
      res:=RegOpenKeyEx(HKEY_DYN_DATA, 'PerfStats\StatData',0,KEY_ALL_ACCESS,pkey);
      if res<>0 then
        raise exception.Create('Could not open registry key');
      //Для Dial Up Адаптера
      RegQueryValueEx(pkey,'Dial-Up Adapter\Alignment',nil,regtype,@fDialupAdapterInfo.alignment,@vsize);
      RegQueryValueEx(pkey,'Dial-Up Adapter\Buffer',nil,regtype,@fDialupAdapterInfo.buffer,@vsize);
      RegQueryValueEx(pkey,'Dial-Up Adapter\Framing',nil,regtype,@fDialupAdapterInfo.framing,@vsize);
      RegQueryValueEx(pkey,'Dial-Up Adapter\Overrun ',nil,regtype,@fDialupAdapterInfo.overrun,@vsize);
      RegQueryValueEx(pkey,'Dial-Up Adapter\Timeout',nil,regtype,@fDialupAdapterInfo.timeout,@vsize);
      RegQueryValueEx(pkey,'Dial-Up Adapter\CRC',nil,regtype, @fDialupAdapterInfo.crc,@vsize);
      RegQueryValueEx(pkey,'Dial-Up Adapter\Runts',nil,regtype,@fDialupAdapterInfo.runts,@vsize);
      RegQueryValueEx(pkey,'Dial-Up Adapter\FramesXmit',nil,regtype,@fDialupAdapterInfo.framesxmit,@vsize);
      RegQueryValueEx(pkey,'Dial-Up Adapter\FramesRecvd',nil,regtype, @fDialupAdapterInfo.framesrecieved,@vsize);
      RegQueryValueEx(pkey,'Dial-Up Adapter\BytesXmit',nil,regtype,@fDialupAdapterInfo.bytesxmit,@vsize);
      RegQueryValueEx(pkey,'Dial-Up Adapter\BytesRecvd',nil,regtype, @fDialupAdapterInfo.bytesrecieved,@vsize);
      RegQueryValueEx(pkey,'Dial-Up Adapter\TotalBytesXmit',nil,regtype, @fDialupAdapterInfo.totalbytesxmit,@vsize);
      RegQueryValueEx(pkey,'Dial-Up Adapter\TotalBytesRecvd',nil,regtype, @fDialupAdapterInfo.totalbytesrecieved,@vsize);
      RegQueryValueEx(pkey,'Dial-Up Adapter\ConnectSpeed',nil,regtype, @fDialupAdapterInfo.connectspeed,@vsize);
      // Для VCACHE
      RegQueryValueEx(pkey,'VCACHE\LRUBuffers',nil,regtype, @fVCACHEInfo.lrubuffers,@vsize);
      RegQueryValueEx(pkey,'VCACHE\FailedRecycles',nil,regtype, @fVCACHEInfo.failedrecycles,@vsize);
      RegQueryValueEx(pkey,'VCACHE\RandomRecycles',nil,regtype, @fVCACHEInfo.randomrecycles,@vsize);
      RegQueryValueEx(pkey,'VCACHE\LRURecycles',nil,regtype, @fVCACHEInfo.lrurecycles,@vsize);
      RegQueryValueEx(pkey,'VCACHE\Misses',nil,regtype, @fVCACHEInfo.misses,@vsize);
      RegQueryValueEx(pkey,'VCACHE\Hits',nil,regtype,@fVCACHEInfo.hits,@vsize);
      RegQueryValueEx(pkey,'VCACHE\cMacPages',nil,regtype, @fVCACHEInfo.cmacpages,@vsize);
      RegQueryValueEx(pkey,'VCACHE\cMinPages',nil,regtype, @fVCACHEInfo.cminpages,@vsize);
      RegQueryValueEx(pkey,'VCACHE\cCurPages',nil,regtype, @fVCACHEInfo.ccurpages,@vsize);
      //Для VFAT
      RegQueryValueEx(pkey,'VFAT\DirtyData',nil,regtype, @ffatinfo.dirtydata,@vsize);
      RegQueryValueEx(pkey,'VFAT\BReadsSec',nil,regtype, @ffatinfo.breadssec,@vsize);
      RegQueryValueEx(pkey,'VFAT\BWritesSec',nil,regtype, @ffatinfo.bwritessec,@vsize);
      RegQueryValueEx(pkey,'VFAT\ReadsSec',nil,regtype, @ffatinfo.readssec,@vsize);
      RegQueryValueEx(pkey,'VFAT\WritesSec',nil,regtype, @ffatinfo.writessec,@vsize);
      //Для VMM
      RegQueryValueEx(pkey,'VMM\cpgLockedNoncache',nil,regtype, @fvmminfo.cpglockednoncache,@vsize);
      RegQueryValueEx(pkey,'VMM\cpgCommit',nil,regtype, @fvmminfo.cpgcommit,@vsize);
      RegQueryValueEx(pkey,'VMM\cpgSharedPages',nil,regtype, @fvmminfo.cpgsharedpages,@vsize);
      RegQueryValueEx(pkey,'VMM\cpgDiskcacheMid',nil,regtype, @fvmminfo.cpgdiskcacheMid,@vsize);
      RegQueryValueEx(pkey,'VMM\cpgDiskcacheMac',nil,regtype, @fvmminfo.cpgdiskcacheMac,@vsize);
      RegQueryValueEx(pkey,'VMM\cpgDiskcacheMin',nil,regtype, @fvmminfo.cpgdiskcacheMin,@vsize);
      RegQueryValueEx(pkey,'VMM\cpgDiskcache',nil,regtype, @fvmminfo.cpgdiskcache,@vsize);
      RegQueryValueEx(pkey,'VMM\cpgSwapfileDefective',nil,regtype, @fvmminfo.cpgswapfiledefective,@vsize);
      RegQueryValueEx(pkey,'VMM\cpgSwapfileInUse',nil,regtype, @fvmminfo.cpgswapfileinuse,@vsize);
      RegQueryValueEx(pkey,'VMM\cpgSwapfile',nil,regtype, @fvmminfo.cpgswapfile,@vsize);
      RegQueryValueEx(pkey,'VMM\cDiscards',nil,regtype, @fvmminfo.cdiscards,@vsize);
      RegQueryValueEx(pkey,'VMM\cPageOuts',nil,regtype, @fvmminfo.cpageouts,@vsize);
      RegQueryValueEx(pkey,'VMM\cPageIns',nil,regtype, @fvmminfo.cpageins,@vsize);
      RegQueryValueEx(pkey,'VMM\cInstanceFaults',nil,regtype, @fvmminfo.cinstancefaults,@vsize);
      RegQueryValueEx(pkey,'VMM\cPageFaults',nil,regtype, @fvmminfo.cpagefaults,@vsize);
      RegQueryValueEx(pkey,'VMM\cpgOther',nil,regtype, @fvmminfo.cpgother,@vsize);
      RegQueryValueEx(pkey,'VMM\cpgSwap',nil,regtype, @fvmminfo.cpgswap,@vsize);
      RegQueryValueEx(pkey,'VMM\cpgLocked',nil,regtype, @fvmminfo.cpglocked,@vsize);
      RegQueryValueEx(pkey,'VMM\cpgFree',nil,regtype, @fvmminfo.cpgfree,@vsize);
      //Для KERNEL
      RegQueryValueEx(pkey,'KERNEL\CPUUsage',nil,regtype, @fkernelinfo.cpuusagepcnt,@vsize);
      RegQueryValueEx(pkey,'KERNEL\VMs',nil,regtype,@fkernelinfo.numvms,@vsize);
      RegQueryValueEx(pkey,'KERNEL\Threads',nil,regtype, @fkernelinfo.numThreads,@vsize);
      RegCloseKey(pkey);
      if assigned(SysInfoChanged) then
        SysInfoChanged(self);
    end;
     
    procedure TSysInfo.stoprecievingInfo;
    var
      res:integer;
    begin
      res:=RegOpenKeyEx(HKEY_DYN_DATA, 'PerfStats\StopStat',0,KEY_ALL_ACCESS,pkey);
      if not fstopped then
      begin
        if res<>0 then
          raise exception.Create('Could not open registry key');
        //Для Dial Up Адаптера
        RegQueryValueEx(pkey,'Dial-Up Adapter\Alignment',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'Dial-Up Adapter\Buffer',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'Dial-Up Adapter\Framing',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'Dial-Up Adapter\Overrun ',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'Dial-Up Adapter\Timeout',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'Dial-Up Adapter\CRC',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'Dial-Up Adapter\Runts',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'Dial-Up Adapter\FramesXmit',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'Dial-Up Adapter\FramesRecvd',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'Dial-Up Adapter\BytesXmit',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'Dial-Up Adapter\BytesRecvd',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'Dial-Up Adapter\TotalBytesXmit',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'Dial-Up Adapter\TotalBytesRecvd',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'Dial-Up Adapter\ConnectSpeed',nil,regtype,@tmp,@vsize);
     
        // Для VCACHE
        RegQueryValueEx(pkey,'VCACHE\LRUBuffers',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'VCACHE\FailedRecycles',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'VCACHE\RandomRecycles',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'VCACHE\LRURecycles',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'VCACHE\Misses',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'VCACHE\Hits',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'VCACHE\cMacPages',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'VCACHE\cMinPages',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'VCACHE\cCurPages',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'Dial-Up Adapter\BytesXmit',nil,regtype,@tmp,@vsize);
     
        //Для VFAT
        RegQueryValueEx(pkey,'VFAT\DirtyData',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'VFAT\BReadsSec',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'VFAT\BWritesSec',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'VFAT\ReadsSec',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'VFAT\WritesSec',nil,regtype,@tmp,@vsize);
     
        //Для VMM
        RegQueryValueEx(pkey,'VMM\cpgLockedNoncache',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'VMM\cpgCommit',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'VMM\cpgSharedPages',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'VMM\cpgDiskcacheMid',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'VMM\cpgDiskcacheMac',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'VMM\cpgDiskcacheMin',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'VMM\cpgDiskcache',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'VMM\cpgSwapfileDefective',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'VMM\cpgSwapfileInUse',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'VMM\cpgSwapfile',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'VMM\cDiscards',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'VMM\cPageOuts',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'VMM\cPageIns',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'VMM\cInstanceFaults',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'VMM\cPageFaults',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'VMM\cpgOther',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'VMM\cpgSwap',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'VMM\cpgLocked',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'VMM\cpgFree',nil,regtype,@tmp,@vsize);
     
        //Для KERNEL
        RegQueryValueEx(pkey,'KERNEL\CPUUsage',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'KERNEL\VMs',nil,regtype,@tmp,@vsize);
        RegQueryValueEx(pkey,'KERNEL\Threads',nil,regtype,@tmp,@vsize);
     
        RegCloseKey(pkey);
        ftimer.enabled:=false;
        fstopped:=true;
      end;
    end;
     
    procedure tsysinfo.fsetupdateinterval(aupdateinterval:integer);
    begin
      if (ftimer<>nil) and(aupdateinterval>0) then
      begin
        ftimer.Interval:=aupdateinterval;
        fupdateinterval:=aupdateinterval;
      end;
      if (ftimer<>nil) and(aupdateinterval=0) then
      begin
        ftimer.Interval:=500;
        fupdateinterval:=500;
      end;
    end;
     
    destructor tsysinfo.Destroy;
    begin
      StopRecievingInfo;
      ftimer.Destroy;
      inherited;
    end;
     
    procedure register;
    begin
      RegisterComponents('Samples', [TSysInfo]);
    end;
     
    end.
     

Скопируйте это в файл .pas и проинсталлируйте его.
