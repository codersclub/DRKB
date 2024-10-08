---
Title: Читаем заголовок exe-файла
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---

Читаем заголовок exe-файла
==========================

    { You'll need a OpenDialog to open a Exe-File and a Memo to show the file informations } 
     
    procedure DumpDOSHeader(const h: IMAGE_DOS_HEADER; Lines: TStrings); 
    begin 
      Lines.Add('Dump of DOS file header'); 
      Lines.Add(Format('Magic number: %d', [h.e_magic])); 
      Lines.Add(Format('Bytes on last page of file: %d', [h.e_cblp])); 
      Lines.Add(Format('Pages in file: %d', [h.e_cp])); 
      Lines.Add(Format('Relocations: %d', [h.e_crlc])); 
      Lines.Add(Format('Size of header in paragraphs: %d', [h.e_cparhdr])); 
      Lines.Add(Format('Minimum extra paragraphs needed: %d', [h.e_minalloc])); 
      Lines.Add(Format('Maximum extra paragraphs needed: %d', [h.e_maxalloc])); 
      Lines.Add(Format('Initial (relative) SS value: %d', [h.e_ss])); 
      Lines.Add(Format('Initial SP value: %d', [h.e_sp])); 
      Lines.Add(Format('Checksum: %d', [h.e_csum])); 
      Lines.Add(Format('Initial IP value: %d', [h.e_ip])); 
      Lines.Add(Format('Initial (relative) CS value: %d', [h.e_cs])); 
      Lines.Add(Format('File address of relocation table: %d', [h.e_lfarlc])); 
      Lines.Add(Format('Overlay number: %d', [h.e_ovno])); 
      Lines.Add(Format('OEM identifier (for e_oeminfo): %d', [h.e_oemid])); 
      Lines.Add(Format('OEM information; e_oemid specific: %d', [h.e_oeminfo])); 
      Lines.Add(Format('File address of new exe header: %d', [h._lfanew])); 
      Lines.Add(''); 
    end; 
     
    procedure DumpPEHeader(const h: IMAGE_FILE_HEADER; Lines: TStrings); 
    var 
      dt: TDateTime; 
    begin 
      Lines.Add('Dump of PE file header'); 
      Lines.Add(Format('Machine: %4x', [h.Machine])); 
      case h.Machine of 
        IMAGE_FILE_MACHINE_UNKNOWN : Lines.Add(' MACHINE_UNKNOWN '); 
        IMAGE_FILE_MACHINE_I386: Lines.Add(' Intel 386. '); 
        IMAGE_FILE_MACHINE_R3000: Lines.Add(' MIPS little-endian, 0x160 big-endian '); 
        IMAGE_FILE_MACHINE_R4000: Lines.Add(' MIPS little-endian '); 
        IMAGE_FILE_MACHINE_R10000: Lines.Add(' MIPS little-endian '); 
        IMAGE_FILE_MACHINE_ALPHA: Lines.Add(' Alpha_AXP '); 
        IMAGE_FILE_MACHINE_POWERPC: Lines.Add(' IBM PowerPC Little-Endian '); 
        // some values no longer defined in winnt.h 
        $14D: Lines.Add(' Intel i860'); 
        $268: Lines.Add(' Motorola 68000'); 
        $290: Lines.Add(' PA RISC'); 
        else 
          Lines.Add(' unknown machine type'); 
      end; { Case } 
      Lines.Add(Format('NumberOfSections: %d', [h.NumberOfSections])); 
      Lines.Add(Format('TimeDateStamp: %d', [h.TimeDateStamp])); 
      dt := EncodeDate(1970, 1, 1) + h.Timedatestamp / SecsPerDay; 
      Lines.Add(FormatDateTime(' c', dt)); 
     
      Lines.Add(Format('PointerToSymbolTable: %d', [h.PointerToSymbolTable])); 
      Lines.Add(Format('NumberOfSymbols: %d', [h.NumberOfSymbols])); 
      Lines.Add(Format('SizeOfOptionalHeader: %d', [h.SizeOfOptionalHeader])); 
      Lines.Add(Format('Characteristics: %d', [h.Characteristics])); 
      if (IMAGE_FILE_DLL and h.Characteristics) <> 0 then 
        Lines.Add(' file is a DLL') 
      else if (IMAGE_FILE_EXECUTABLE_IMAGE and h.Characteristics) <> 0 then 
        Lines.Add(' file is a program'); 
      Lines.Add(''); 
    end; 
     
    procedure DumpOptionalHeader(const h: IMAGE_OPTIONAL_HEADER; Lines: TStrings); 
    begin 
      Lines.Add('Dump of PE optional file header'); 
      Lines.Add(Format('Magic: %d', [h.Magic])); 
      case h.Magic of 
        $107: Lines.Add(' ROM image'); 
        $10b: Lines.Add(' executable image'); 
        else 
          Lines.Add(' unknown image type'); 
      end; { If } 
      Lines.Add(Format('MajorLinkerVersion: %d', [h.MajorLinkerVersion])); 
      Lines.Add(Format('MinorLinkerVersion: %d', [h.MinorLinkerVersion])); 
      Lines.Add(Format('SizeOfCode: %d', [h.SizeOfCode])); 
      Lines.Add(Format('SizeOfInitializedData: %d', [h.SizeOfInitializedData])); 
      Lines.Add(Format('SizeOfUninitializedData: %d', [h.SizeOfUninitializedData])); 
      Lines.Add(Format('AddressOfEntryPoint: %d', [h.AddressOfEntryPoint])); 
      Lines.Add(Format('BaseOfCode: %d', [h.BaseOfCode])); 
      Lines.Add(Format('BaseOfData: %d', [h.BaseOfData])); 
      Lines.Add(Format('ImageBase: %d', [h.ImageBase])); 
      Lines.Add(Format('SectionAlignment: %d', [h.SectionAlignment])); 
      Lines.Add(Format('FileAlignment: %d', [h.FileAlignment])); 
      Lines.Add(Format('MajorOperatingSystemVersion: %d', [h.MajorOperatingSystemVersion])); 
      Lines.Add(Format('MinorOperatingSystemVersion: %d', [h.MinorOperatingSystemVersion])); 
      Lines.Add(Format('MajorImageVersion: %d', [h.MajorImageVersion])); 
      Lines.Add(Format('MinorImageVersion: %d', [h.MinorImageVersion])); 
      Lines.Add(Format('MajorSubsystemVersion: %d', [h.MajorSubsystemVersion])); 
      Lines.Add(Format('MinorSubsystemVersion: %d', [h.MinorSubsystemVersion])); 
      Lines.Add(Format('Win32VersionValue: %d', [h.Win32VersionValue])); 
      Lines.Add(Format('SizeOfImage: %d', [h.SizeOfImage])); 
      Lines.Add(Format('SizeOfHeaders: %d', [h.SizeOfHeaders])); 
      Lines.Add(Format('CheckSum: %d', [h.CheckSum])); 
      Lines.Add(Format('Subsystem: %d', [h.Subsystem])); 
      case h.Subsystem of 
        IMAGE_SUBSYSTEM_NATIVE: 
          Lines.Add(' Image doesnot require a subsystem. '); 
        IMAGE_SUBSYSTEM_WINDOWS_GUI: 
          Lines.Add(' Image runs in the Windows GUI subsystem. '); 
        IMAGE_SUBSYSTEM_WINDOWS_CUI: 
          Lines.Add(' Image runs in the Windows character subsystem. '); 
        IMAGE_SUBSYSTEM_OS2_CUI: 
          Lines.Add(' image runs in the OS/2 character subsystem. '); 
        IMAGE_SUBSYSTEM_POSIX_CUI: 
          Lines.Add(' image run in the Posix character subsystem. '); 
        else 
          Lines.Add(' unknown subsystem') 
      end; { Case } 
      Lines.Add(Format('DllCharacteristics: %d', [h.DllCharacteristics])); 
      Lines.Add(Format('SizeOfStackReserve: %d', [h.SizeOfStackReserve])); 
      Lines.Add(Format('SizeOfStackCommit: %d', [h.SizeOfStackCommit])); 
      Lines.Add(Format('SizeOfHeapReserve: %d', [h.SizeOfHeapReserve])); 
      Lines.Add(Format('SizeOfHeapCommit: %d', [h.SizeOfHeapCommit])); 
      Lines.Add(Format('LoaderFlags: %d', [h.LoaderFlags])); 
      Lines.Add(Format('NumberOfRvaAndSizes: %d', [h.NumberOfRvaAndSizes])); 
    end; 
     
    // Example Call, Beispielaufruf: 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    var 
      fs: TFilestream; 
      signature: DWORD; 
      dos_header: IMAGE_DOS_HEADER; 
      pe_header: IMAGE_FILE_HEADER; 
      opt_header: IMAGE_OPTIONAL_HEADER; 
    begin 
      memo1.Clear; 
      with Opendialog1 do 
      begin 
        Filter := 'Executables (*.EXE)|*.EXE'; 
        if Execute then 
        begin 
          fs := TFilestream.Create(FileName, fmOpenread or fmShareDenyNone); 
          try 
            fs.read(dos_header, SizeOf(dos_header)); 
            if dos_header.e_magic <> IMAGE_DOS_SIGNATURE then 
            begin 
              memo1.Lines.Add('Invalid DOS file header'); 
              Exit; 
            end; 
            DumpDOSHeader(dos_header, memo1.Lines); 
     
            fs.seek(dos_header._lfanew, soFromBeginning); 
            fs.read(signature, SizeOf(signature)); 
            if signature <> IMAGE_NT_SIGNATURE then 
            begin 
              memo1.Lines.Add('Invalid PE header'); 
              Exit; 
            end; 
     
            fs.read(pe_header, SizeOf(pe_header)); 
            DumpPEHeader(pe_header, memo1.Lines); 
     
            if pe_header.SizeOfOptionalHeader > 0 then 
            begin 
              fs.read(opt_header, SizeOf(opt_header)); 
              DumpOptionalHeader(opt_header, memo1.Lines); 
            end; 
          finally 
            fs.Free; 
          end; { finally } 
        end; 
      end; 
    end; 

