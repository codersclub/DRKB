---
Title: Как работать со сканером?
Date: 12.06.2002
---


Как работать со сканером?
=========================

Вариант 1:

Author: M. de Haan

Source: Delphi Knowledge Base: <https://www.baltsoft.com/>

    ////////////////////////////////////////////////////////////////////////
    //                                                                    //
    //               Delphi Scanner Support Framework                     //
    //                                                                    //
    //               Copyright (C) 1999 by Uli Tessel                     //
    //                                                                    //
    ////////////////////////////////////////////////////////////////////////
    //                                                                    //
    //         Modified and rewritten as a Delphi component by:           //
    //                                                                    //
    //                           M. de Haan                               //
    //                                                                    //
    //                           June 2002                                //
    //                                                                    //
    ////////////////////////////////////////////////////////////////////////
     
    unit
      TWAIN;
     
    interface
     
    uses
      SysUtils, // Exceptions
      Forms, // TMessageEvent
      Windows, // HMODULE
      Graphics, // TBitmap
      IniFiles, // Inifile
      Controls, // TCursor
      Classes; // Class
     
    const
      // Messages
      MSG_GET = $0001; // Get one or more values
      MSG_GETCURRENT = $0002; // Get current value
      MSG_GETDEFAULT = $0003; // Get default (e.g. power up) value
      MSG_GETFIRST = $0004; // Get first of a series of items,
      // e.g. Data Sources
      MSG_GETNEXT = $0005; // Iterate through a series of items
      MSG_SET = $0006; // Set one or more values
      MSG_RESET = $0007; // Set current value to default value
      MSG_QUERYSUPPORT = $0008; // Get supported operations on the
      // capacities
     
      // Messages used with DAT_NULL
      // ---------------------------
      MSG_XFERREADY = $0101; // The data source has data ready
      MSG_CLOSEDSREQ = $0102; // Request for the application to close
      // the Data Source
      MSG_CLOSEDSOK = $0103; // Tell the application to save the
      // state
      MSG_DEVICEEVENT = $0104; // Some event has taken place
     
      // Messages used with a pointer to a DAT_STATUS structure
      // ------------------------------------------------------
      MSG_CHECKSTATUS = $0201; // Get status information
     
      // Messages used with a pointer to DAT_PARENT data
      // -----------------------------------------------
      MSG_OPENDSM = $0301; // Open the Data Source Manager
      MSG_CLOSEDSM = $0302; // Close the Data Source Manager
     
      // Messages used with a pointer to a DAT_IDENTITY structure
      // --------------------------------------------------------
      MSG_OPENDS = $0401; // Open a Data Source
      MSG_CLOSEDS = $0402; // Close a Data Source
      MSG_USERSELECT = $0403; // Put up a dialog of all Data Sources
      // The user can select a Data Source
     
      // Messages used with a pointer to a DAT_USERINTERFACE structure
      // -------------------------------------------------------------
      MSG_DISABLEDS = $0501; // Disable data transfer in the Data
      // Source
      MSG_ENABLEDS = $0502; // Enable data transfer in the Data
      // Source
      MSG_ENABLEDSUIONLY = $0503; // Enable for saving Data Source state
      // only
     
      // Messages used with a pointer to a DAT_EVENT structure
      // -----------------------------------------------------
      MSG_PROCESSEVENT = $0601;
     
      // Messages used with a pointer to a DAT_PENDINGXFERS structure
      // ------------------------------------------------------------
      MSG_ENDXFER = $0701;
      MSG_STOPFEEDER = $0702;
     
      // Messages used with a pointer to a DAT_FILESYSTEM structure
      // ----------------------------------------------------------
      MSG_CHANGEDIRECTORY = $0801;
      MSG_CREATEDIRECTORY = $0802;
      MSG_DELETE = $0803;
      MSG_FORMATMEDIA = $0804;
      MSG_GETCLOSE = $0805;
      MSG_GETFIRSTFILE = $0806;
      MSG_GETINFO = $0807;
      MSG_GETNEXTFILE = $0808;
      MSG_RENAME = $0809;
      MSG_COPY = $080A;
      MSG_AUTOMATICCAPTUREDIRECTORY = $080B;
     
      // Messages used with a pointer to a DAT_PASSTHRU structure
      // --------------------------------------------------------
      MSG_PASSTHRU = $0901;
     
    const
      DG_CONTROL = $0001; // data pertaining to control
      DG_IMAGE = $0002; // data pertaining to raster images
     
    const
      // Data Argument Types for the DG_CONTROL Data Group.
      DAT_CAPABILITY = $0001; // TW_CAPABILITY
      DAT_EVENT = $0002; // TW_EVENT
      DAT_IDENTITY = $0003; // TW_IDENTITY
      DAT_PARENT = $0004; // TW_HANDLE,
      // application win handle in Windows
      DAT_PENDINGXFERS = $0005; // TW_PENDINGXFERS
      DAT_SETUPMEMXFER = $0006; // TW_SETUPMEMXFER
      DAT_SETUPFILEXFER = $0007; // TW_SETUPFILEXFER
      DAT_STATUS = $0008; // TW_STATUS
      DAT_USERINTERFACE = $0009; // TW_USERINTERFACE
      DAT_XFERGROUP = $000A; // TW_UINT32
      DAT_IMAGEMEMXFER = $0103; // TW_IMAGEMEMXFER
      DAT_IMAGENATIVEXFER = $0104; // TW_UINT32, loword is hDIB, PICHandle
      DAT_IMAGEFILEXFER = $0105; // Null data
     
    const
      // Condition Codes: Application gets these by doing DG_CONTROL
      // DAT_STATUS MSG_GET.
      TWCC_CUSTOMBASE = $8000;
      TWCC_SUCCESS = 00; // It worked!
      TWCC_BUMMER = 01; // Failure due to unknown causes
      TWCC_LOWMEMORY = 02; // Not enough memory to perform operation
      TWCC_NODS = 03; // No Data Source
      TWCC_MAXCONNECTIONS = 04; // Data Source is connected to maximum
      // number of possible applications
      TWCC_OPERATIONERROR = 05; // Data Source or Data Source Manager
      // reported error, application
      // shouldn't report an error
      TWCC_BADCAP = 06; // Unknown capability
      TWCC_BADPROTOCOL = 09; // Unrecognized MSG DG DAT combination
      TWCC_BADVALUE = 10; // Data parameter out of range
      TWCC_SEQERROR = 11; // DG DAT MSG out of expected sequence
      TWCC_BADDEST = 12; // Unknown destination Application /
      // Source in DSM_Entry
      TWCC_CAPUNSUPPORTED = 13; // Capability not supported by source
      TWCC_CAPBADOPERATION = 14; // Operation not supported by
      // capability
      TWCC_CAPSEQERROR = 15; // Capability has dependancy on other
      // capability
      TWCC_DENIED = 16; // File System operation is denied
      // (file is protected)
      TWCC_FILEEXISTS = 17; // Operation failed because file
      // already exists
      TWCC_FILENOTFOUND = 18; // File not found
      TWCC_NOTEMPTY = 19; // Operation failed because directory
      // is not empty
      TWCC_PAPERJAM = 20; // The feeder is jammed
      TWCC_PAPERDOUBLEFEED = 21; // The feeder detected multiple pages
      TWCC_FILEWRITEERROR = 22; // Error writing the file (meant for
      // things like disk full conditions)
      TWCC_CHECKDEVICEONLINE = 23; // The device went offline prior to or
      // during this operation
     
    const
      // Flags used in TW_MEMORY structure
      TWMF_APPOWNS = $01;
      TWMF_DSMOWNS = $02;
      TWMF_DSOWNS = $04;
      TWMF_POINTER = $08;
      TWMF_HANDLE = $10;
     
    const
      // Flags for country, which seems to be equal to their telephone
      // number
      TWCY_AFGHANISTAN = 1001;
      TWCY_ALGERIA = 0213;
      TWCY_AMERICANSAMOA = 0684;
      TWCY_ANDORRA = 0033;
      TWCY_ANGOLA = 1002;
      TWCY_ANGUILLA = 8090;
      TWCY_ANTIGUA = 8091;
      TWCY_ARGENTINA = 0054;
      TWCY_ARUBA = 0297;
      TWCY_ASCENSIONI = 0247;
      TWCY_AUSTRALIA = 0061;
      TWCY_AUSTRIA = 0043;
      TWCY_BAHAMAS = 8092;
      TWCY_BAHRAIN = 0973;
      TWCY_BANGLADESH = 0880;
      TWCY_BARBADOS = 8093;
      TWCY_BELGIUM = 0032;
      TWCY_BELIZE = 0501;
      TWCY_BENIN = 0229;
      TWCY_BERMUDA = 8094;
      TWCY_BHUTAN = 1003;
      TWCY_BOLIVIA = 0591;
      TWCY_BOTSWANA = 0267;
      TWCY_BRITAIN = 0006;
      TWCY_BRITVIRGINIS = 8095;
      TWCY_BRAZIL = 0055;
      TWCY_BRUNEI = 0673;
      TWCY_BULGARIA = 0359;
      TWCY_BURKINAFASO = 1004;
      TWCY_BURMA = 1005;
      TWCY_BURUNDI = 1006;
      TWCY_CAMAROON = 0237;
      TWCY_CANADA = 0002;
      TWCY_CAPEVERDEIS = 0238;
      TWCY_CAYMANIS = 8096;
      TWCY_CENTRALAFREP = 1007;
      TWCY_CHAD = 1008;
      TWCY_CHILE = 0056;
      TWCY_CHINA = 0086;
      TWCY_CHRISTMASIS = 1009;
      TWCY_COCOSIS = 1009;
      TWCY_COLOMBIA = 0057;
      TWCY_COMOROS = 1010;
      TWCY_CONGO = 1011;
      TWCY_COOKIS = 1012;
      TWCY_COSTARICA = 0506;
      TWCY_CUBA = 0005;
      TWCY_CYPRUS = 0357;
      TWCY_CZECHOSLOVAKIA = 0042;
      TWCY_DENMARK = 0045;
      TWCY_DJIBOUTI = 1013;
      TWCY_DOMINICA = 8097;
      TWCY_DOMINCANREP = 8098;
      TWCY_EASTERIS = 1014;
      TWCY_ECUADOR = 0593;
      TWCY_EGYPT = 0020;
      TWCY_ELSALVADOR = 0503;
      TWCY_EQGUINEA = 1015;
      TWCY_ETHIOPIA = 0251;
      TWCY_FALKLANDIS = 1016;
      TWCY_FAEROEIS = 0298;
      TWCY_FIJIISLANDS = 0679;
      TWCY_FINLAND = 0358;
      TWCY_FRANCE = 0033;
      TWCY_FRANTILLES = 0596;
      TWCY_FRGUIANA = 0594;
      TWCY_FRPOLYNEISA = 0689;
      TWCY_FUTANAIS = 1043;
      TWCY_GABON = 0241;
      TWCY_GAMBIA = 0220;
      TWCY_GERMANY = 0049;
      TWCY_GHANA = 0233;
      TWCY_GIBRALTER = 0350;
      TWCY_GREECE = 0030;
      TWCY_GREENLAND = 0299;
      TWCY_GRENADA = 8099;
      TWCY_GRENEDINES = 8015;
      TWCY_GUADELOUPE = 0590;
      TWCY_GUAM = 0671;
      TWCY_GUANTANAMOBAY = 5399;
      TWCY_GUATEMALA = 0502;
      TWCY_GUINEA = 0224;
      TWCY_GUINEABISSAU = 1017;
      TWCY_GUYANA = 0592;
      TWCY_HAITI = 0509;
      TWCY_HONDURAS = 0504;
      TWCY_HONGKONG = 0852;
      TWCY_HUNGARY = 0036;
      TWCY_ICELAND = 0354;
      TWCY_INDIA = 0091;
      TWCY_INDONESIA = 0062;
      TWCY_IRAN = 0098;
      TWCY_IRAQ = 0964;
      TWCY_IRELAND = 0353;
      TWCY_ISRAEL = 0972;
      TWCY_ITALY = 0039;
      TWCY_IVORYCOAST = 0225;
      TWCY_JAMAICA = 8010;
      TWCY_JAPAN = 0081;
      TWCY_JORDAN = 0962;
      TWCY_KENYA = 0254;
      TWCY_KIRIBATI = 1018;
      TWCY_KOREA = 0082;
      TWCY_KUWAIT = 0965;
      TWCY_LAOS = 1019;
      TWCY_LEBANON = 1020;
      TWCY_LIBERIA = 0231;
      TWCY_LIBYA = 0218;
      TWCY_LIECHTENSTEIN = 0041;
      TWCY_LUXENBOURG = 0352;
      TWCY_MACAO = 0853;
      TWCY_MADAGASCAR = 1021;
      TWCY_MALAWI = 0265;
      TWCY_MALAYSIA = 0060;
      TWCY_MALDIVES = 0960;
      TWCY_MALI = 1022;
      TWCY_MALTA = 0356;
      TWCY_MARSHALLIS = 0692;
      TWCY_MAURITANIA = 1023;
      TWCY_MAURITIUS = 0230;
      TWCY_MEXICO = 0003;
      TWCY_MICRONESIA = 0691;
      TWCY_MIQUELON = 0508;
      TWCY_MONACO = 0033;
      TWCY_MONGOLIA = 1024;
      TWCY_MONTSERRAT = 8011;
      TWCY_MOROCCO = 0212;
      TWCY_MOZAMBIQUE = 1025;
      TWCY_NAMIBIA = 0264;
      TWCY_NAURU = 1026;
      TWCY_NEPAL = 0977;
      TWCY_NETHERLANDS = 0031;
      TWCY_NETHANTILLES = 0599;
      TWCY_NEVIS = 8012;
      TWCY_NEWCALEDONIA = 0687;
      TWCY_NEWZEALAND = 0064;
      TWCY_NICARAGUA = 0505;
      TWCY_NIGER = 0227;
      TWCY_NIGERIA = 0234;
      TWCY_NIUE = 1027;
      TWCY_NORFOLKI = 1028;
      TWCY_NORWAY = 0047;
      TWCY_OMAN = 0968;
      TWCY_PAKISTAN = 0092;
      TWCY_PALAU = 1029;
      TWCY_PANAMA = 0507;
      TWCY_PARAGUAY = 0595;
      TWCY_PERU = 0051;
      TWCY_PHILLIPPINES = 0063;
      TWCY_PITCAIRNIS = 1030;
      TWCY_PNEWGUINEA = 0675;
      TWCY_POLAND = 0048;
      TWCY_PORTUGAL = 0351;
      TWCY_QATAR = 0974;
      TWCY_REUNIONI = 1031;
      TWCY_ROMANIA = 0040;
      TWCY_RWANDA = 0250;
      TWCY_SAIPAN = 0670;
      TWCY_SANMARINO = 0039;
      TWCY_SAOTOME = 1033;
      TWCY_SAUDIARABIA = 0966;
      TWCY_SENEGAL = 0221;
      TWCY_SEYCHELLESIS = 1034;
      TWCY_SIERRALEONE = 1035;
      TWCY_SINGAPORE = 0065;
      TWCY_SOLOMONIS = 1036;
      TWCY_SOMALI = 1037;
      TWCY_SOUTHAFRICA = 0027;
      TWCY_SPAIN = 0034;
      TWCY_SRILANKA = 0094;
      TWCY_STHELENA = 1032;
      TWCY_STKITTS = 8013;
      TWCY_STLUCIA = 8014;
      TWCY_STPIERRE = 0508;
      TWCY_STVINCENT = 8015;
      TWCY_SUDAN = 1038;
      TWCY_SURINAME = 0597;
      TWCY_SWAZILAND = 0268;
      TWCY_SWEDEN = 0046;
      TWCY_SWITZERLAND = 0041;
      TWCY_SYRIA = 1039;
      TWCY_TAIWAN = 0886;
      TWCY_TANZANIA = 0255;
      TWCY_THAILAND = 0066;
      TWCY_TOBAGO = 8016;
      TWCY_TOGO = 0228;
      TWCY_TONGAIS = 0676;
      TWCY_TRINIDAD = 8016;
      TWCY_TUNISIA = 0216;
      TWCY_TURKEY = 0090;
      TWCY_TURKSCAICOS = 8017;
      TWCY_TUVALU = 1040;
      TWCY_UGANDA = 0256;
      TWCY_USSR = 0007;
      TWCY_UAEMIRATES = 0971;
      TWCY_UNITEDKINGDOM = 0044;
      TWCY_USA = 0001;
      TWCY_URUGUAY = 0598;
      TWCY_VANUATU = 1041;
      TWCY_VATICANCITY = 0039;
      TWCY_VENEZUELA = 0058;
      TWCY_WAKE = 1042;
      TWCY_WALLISIS = 1043;
      TWCY_WESTERNSAHARA = 1044;
      TWCY_WESTERNSAMOA = 1045;
      TWCY_YEMEN = 1046;
      TWCY_YUGOSLAVIA = 0038;
      TWCY_ZAIRE = 0243;
      TWCY_ZAMBIA = 0260;
      TWCY_ZIMBABWE = 0263;
      TWCY_ALBANIA = 0355;
      TWCY_ARMENIA = 0374;
      TWCY_AZERBAIJAN = 0994;
      TWCY_BELARUS = 0375;
      TWCY_BOSNIAHERZGO = 0387;
      TWCY_CAMBODIA = 0855;
      TWCY_CROATIA = 0385;
      TWCY_CZECHREPUBLIC = 0420;
      TWCY_DIEGOGARCIA = 0246;
      TWCY_ERITREA = 0291;
      TWCY_ESTONIA = 0372;
      TWCY_GEORGIA = 0995;
      TWCY_LATVIA = 0371;
      TWCY_LESOTHO = 0266;
      TWCY_LITHUANIA = 0370;
      TWCY_MACEDONIA = 0389;
      TWCY_MAYOTTEIS = 0269;
      TWCY_MOLDOVA = 0373;
      TWCY_MYANMAR = 0095;
      TWCY_NORTHKOREA = 0850;
      TWCY_PUERTORICO = 0787;
      TWCY_RUSSIA = 0007;
      TWCY_SERBIA = 0381;
      TWCY_SLOVAKIA = 0421;
      TWCY_SLOVENIA = 0386;
      TWCY_SOUTHKOREA = 0082;
      TWCY_UKRAINE = 0380;
      TWCY_USVIRGINIS = 0340;
      TWCY_VIETNAM = 0084;
     
    const
      // Flags for languages
      TWLG_DAN = 000; // Danish
      TWLG_DUT = 001; // Dutch
      TWLG_ENG = 002; // English
      TWLG_FCF = 003; // French Canadian
      TWLG_FIN = 004; // Finnish
      TWLG_FRN = 005; // French
      TWLG_GER = 006; // German
      TWLG_ICE = 007; // Icelandic
      TWLG_ITN = 008; // Italian
      TWLG_NOR = 009; // Norwegian
      TWLG_POR = 010; // Portuguese
      TWLG_SPA = 011; // Spannish
      TWLG_SWE = 012; // Swedish
      TWLG_USA = 013;
      TWLG_AFRIKAANS = 014;
      TWLG_ALBANIA = 015;
      TWLG_ARABIC = 016;
      TWLG_ARABIC_ALGERIA = 017;
      TWLG_ARABIC_BAHRAIN = 018;
      TWLG_ARABIC_EGYPT = 019;
      TWLG_ARABIC_IRAQ = 020;
      TWLG_ARABIC_JORDAN = 021;
      TWLG_ARABIC_KUWAIT = 022;
      TWLG_ARABIC_LEBANON = 023;
      TWLG_ARABIC_LIBYA = 024;
      TWLG_ARABIC_MOROCCO = 025;
      TWLG_ARABIC_OMAN = 026;
      TWLG_ARABIC_QATAR = 027;
      TWLG_ARABIC_SAUDIARABIA = 028;
      TWLG_ARABIC_SYRIA = 029;
      TWLG_ARABIC_TUNISIA = 030;
      TWLG_ARABIC_UAE = 031; // United Arabic Emirates
      TWLG_ARABIC_YEMEN = 032;
      TWLG_BASQUE = 033;
      TWLG_BYELORUSSIAN = 034;
      TWLG_BULGARIAN = 035;
      TWLG_CATALAN = 036;
      TWLG_CHINESE = 037;
      TWLG_CHINESE_HONGKONG = 038;
      TWLG_CHINESE_PRC = 039; // People's Republic of China
      TWLG_CHINESE_SINGAPORE = 040;
      TWLG_CHINESE_SIMPLIFIED = 041;
      TWLG_CHINESE_TAIWAN = 042;
      TWLG_CHINESE_TRADITIONAL = 043;
      TWLG_CROATIA = 044;
      TWLG_CZECH = 045;
      TWLG_DANISH = TWLG_DAN;
      TWLG_DUTCH = TWLG_DUT;
      TWLG_DUTCH_BELGIAN = 046;
      TWLG_ENGLISH = TWLG_ENG;
      TWLG_ENGLISH_AUSTRALIAN = 047;
      TWLG_ENGLISH_CANADIAN = 048;
      TWLG_ENGLISH_IRELAND = 049;
      TWLG_ENGLISH_NEWZEALAND = 050;
      TWLG_ENGLISH_SOUTHAFRICA = 051;
      TWLG_ENGLISH_UK = 052;
      TWLG_ENGLISH_USA = TWLG_USA;
      TWLG_ESTONIAN = 053;
      TWLG_FAEROESE = 054;
      TWLG_FARSI = 055;
      TWLG_FINNISH = TWLG_FIN;
      TWLG_FRENCH = TWLG_FRN;
      TWLG_FRENCH_BELGIAN = 056;
      TWLG_FRENCH_CANADIAN = TWLG_FCF;
      TWLG_FRENCH_LUXEMBOURG = 057;
      TWLG_FRENCH_SWISS = 058;
      TWLG_GERMAN = TWLG_GER;
      TWLG_GERMAN_AUSTRIAN = 059;
      TWLG_GERMAN_LUXEMBOURG = 060;
      TWLG_GERMAN_LIECHTENSTEIN = 061;
      TWLG_GERMAN_SWISS = 062;
      TWLG_GREEK = 063;
      TWLG_HEBREW = 064;
      TWLG_HUNGARIAN = 065;
      TWLG_ICELANDIC = TWLG_ICE;
      TWLG_INDONESIAN = 066;
      TWLG_ITALIAN = TWLG_ITN;
      TWLG_ITALIAN_SWISS = 067;
      TWLG_JAPANESE = 068;
      TWLG_KOREAN = 069;
      TWLG_KOREAN_JOHAB = 070;
      TWLG_LATVIAN = 071;
      TWLG_LITHUANIAN = 072;
      TWLG_NORWEGIAN = TWLG_NOR;
      TWLG_NORWEGIAN_BOKMAL = 073;
      TWLG_NORWEGIAN_NYNORSK = 074;
      TWLG_POLISH = 075;
      TWLG_PORTUGUESE = TWLG_POR;
      TWLG_PORTUGUESE_BRAZIL = 076;
      TWLG_ROMANIAN = 077;
      TWLG_RUSSIAN = 078;
      TWLG_SERBIAN_LATIN = 079;
      TWLG_SLOVAK = 080;
      TWLG_SLOVENIAN = 081;
      TWLG_SPANISH = TWLG_SPA;
      TWLG_SPANISH_MEXICAN = 082;
      TWLG_SPANISH_MODERN = 083;
      TWLG_SWEDISH = TWLG_SWE;
      TWLG_THAI = 084;
      TWLG_TURKISH = 085;
      TWLG_UKRANIAN = 086;
      TWLG_ASSAMESE = 087;
      TWLG_BENGALI = 088;
      TWLG_BIHARI = 089;
      TWLG_BODO = 090;
      TWLG_DOGRI = 091;
      TWLG_GUJARATI = 092;
      TWLG_HARYANVI = 093;
      TWLG_HINDI = 094;
      TWLG_KANNADA = 095;
      TWLG_KASHMIRI = 096;
      TWLG_MALAYALAM = 097;
      TWLG_MARATHI = 098;
      TWLG_MARWARI = 099;
      TWLG_MEGHALAYAN = 100;
      TWLG_MIZO = 101;
      TWLG_NAGA = 102;
      TWLG_ORISSI = 103;
      TWLG_PUNJABI = 104;
      TWLG_PUSHTU = 105;
      TWLG_SERBIAN_CYRILLIC = 106;
      TWLG_SIKKIMI = 107;
      TWLG_SWEDISH_FINLAND = 108;
      TWLG_TAMIL = 109;
      TWLG_TELUGU = 110;
      TWLG_TRIPURI = 111;
      TWLG_URDU = 112;
      TWLG_VIETNAMESE = 113;
     
    const
      TWRC_SUCCESS = 0;
      TWRC_FAILURE = 1; // Application may get TW_STATUS for
      // info on failure
      TWRC_CHECKSTATUS = 2; // tried hard to get the status
      TWRC_CANCEL = 3;
      TWRC_DSEVENT = 4;
      TWRC_NOTDSEVENT = 5;
      TWRC_XFERDONE = 6;
      TWRC_ENDOFLIST = 7; // After MSG_GETNEXT if nothing left
      TWRC_INFONOTSUPPORTED = 8;
      TWRC_DATANOTAVAILABLE = 9;
     
    const
      TWON_ONEVALUE = $05; // indicates TW_ONEVALUE container
      TWON_DONTCARE8 = $FF;
     
    const
      ICAP_XFERMECH = $0103;
     
    const
      TWTY_UINT16 = $0004; // Means: item is a TW_UINT16
     
    const
      // ICAP_XFERMECH values (SX_ means Setup XFer)
      TWSX_NATIVE = 0;
      TWSX_FILE = 1;
      TWSX_MEMORY = 2;
      TWSX_FILE2 = 3;
     
    type
      TW_UINT16 = WORD; // unsigned short TW_UINT16
      pTW_UINT16 = ^TW_UINT16;
      TTWUInt16 = TW_UINT16;
      PTWUInt16 = pTW_UINT16;
     
    type
      TW_BOOL = WORDBOOL; // unsigned short TW_BOOL
      pTW_BOOL = ^TW_BOOL;
      TTWBool = TW_BOOL;
      PTWBool = pTW_BOOL;
     
    type
      TW_STR32 = array[0..33] of Char; // char TW_STR32[34]
      pTW_STR32 = ^TW_STR32;
      TTWStr32 = TW_STR32;
      PTWStr32 = pTW_STR32;
     
    type
      TW_STR255 = array[0..255] of Char; // char TW_STR255[256]
      pTW_STR255 = ^TW_STR255;
      TTWStr255 = TW_STR255;
      PTWStr255 = pTW_STR255;
     
    type
      TW_INT16 = SmallInt; // short TW_INT16
      pTW_INT16 = ^TW_INT16;
      TTWInt16 = TW_INT16;
      PTWInt16 = pTW_INT16;
     
    type
      TW_UINT32 = ULONG; // unsigned long TW_UINT32
      pTW_UINT32 = ^TW_UINT32;
      TTWUInt32 = TW_UINT32;
      PTWUInt32 = pTW_UINT32;
     
    type
      TW_HANDLE = THandle;
      TTWHandle = TW_HANDLE;
      TW_MEMREF = Pointer;
      TTWMemRef = TW_MEMREF;
     
    type
      // DAT_PENDINGXFERS. Used with MSG_ENDXFER to indicate additional
      // data
      TW_PENDINGXFERS = packed record
        Count: TW_UINT16;
        case Boolean of
          False: (EOJ: TW_UINT32);
          True: (Reserved: TW_UINT32);
      end;
      pTW_PENDINGXFERS = ^TW_PENDINGXFERS;
      TTWPendingXFERS = TW_PENDINGXFERS;
      PTWPendingXFERS = pTW_PENDINGXFERS;
     
    type
      // DAT_EVENT. For passing events down from the application to the DS
      TW_EVENT = packed record
        pEvent: TW_MEMREF; // Windows pMSG or Mac pEvent.
        TWMessage: TW_UINT16; // TW msg from data source, e.g.
        // MSG_XFERREADY
      end;
      pTW_EVENT = ^TW_EVENT;
      TTWEvent = TW_EVENT;
      PTWEvent = pTW_EVENT;
     
    type
      // TWON_ONEVALUE. Container for one value
      TW_ONEVALUE = packed record
        ItemType: TW_UINT16;
        Item: TW_UINT32;
      end;
      pTW_ONEVALUE = ^TW_ONEVALUE;
      TTWOneValue = TW_ONEVALUE;
      PTWOneValue = pTW_ONEVALUE;
     
    type
      // DAT_CAPABILITY. Used by application to get/set capability from/in
      // a data source.
      TW_CAPABILITY = packed record
        Cap: TW_UINT16; // id of capability to set or get, e.g.
        // CAP_BRIGHTNESS
        ConType: TW_UINT16; // TWON_ONEVALUE, _RANGE, _ENUMERATION or
        // _ARRAY
        hContainer: TW_HANDLE; // Handle to container of type Dat
      end;
      pTW_CAPABILITY = ^TW_CAPABILITY;
      TTWCapability = TW_CAPABILITY;
      PTWCapability = pTW_CAPABILITY;
     
    type
      // DAT_STATUS. Application gets detailed status info from a data
      // source with this
      TW_STATUS = packed record
        ConditionCode: TW_UINT16; // Any TWCC_xxx constant
        Reserved: TW_UINT16; // Future expansion space
      end;
      pTW_STATUS = ^TW_STATUS;
      TTWStatus = TW_STATUS;
      PTWStatus = pTW_STATUS;
     
    type
      // No DAT needed. Used to manage memory buffers
      TW_MEMORY = packed record
        Flags: TW_UINT32; // Any combination of the TWMF_ constants
        Length: TW_UINT32; // Number of bytes stored in buffer TheMem
        TheMem: TW_MEMREF; // Pointer or handle to the allocated memory
        // buffer
      end;
      pTW_MEMORY = ^TW_MEMORY;
      TTWMemory = TW_MEMORY;
      PTWMemory = pTW_MEMORY;
     
    const
      // ICAP_IMAGEFILEFORMAT values (FF_means File Format
      TWFF_TIFF = 0; // Tagged Image File Format
      TWFF_PICT = 1; // Macintosh PICT
      TWFF_BMP = 2; // Windows Bitmap
      TWFF_XBM = 3; // X-Windows Bitmap
      TWFF_JFIF = 4; // JPEG File Interchange Format
      TWFF_FPX = 5; // Flash Pix
      TWFF_TIFFMULTI = 6; // Multi-page tiff file
      TWFF_PNG = 7; // Portable Network Graphic
      TWFF_SPIFF = 8;
      TWFF_EXIF = 9;
     
    type
      // DAT_SETUPFILEXFER. Sets up DS to application data transfer via a
      // file
      TW_SETUPFILEXFER = packed record
        FileName: TW_STR255;
        Format: TW_UINT16; // Any TWFF_xxx constant
        VRefNum: TW_INT16; // Used for Mac only
      end;
      pTW_SETUPFILEXFER = ^TW_SETUPFILEXFER;
      TTWSetupFileXFER = TW_SETUPFILEXFER;
      PTWSetupFileXFER = pTW_SETUPFILEXFER;
     
    type
      // DAT_SETUPFILEXFER2. Sets up DS to application data transfer via a
      // file. }
      TW_SETUPFILEXFER2 = packed record
        FileName: TW_MEMREF; // Pointer to file name text
        FileNameType: TW_UINT16; // TWTY_STR1024 or TWTY_UNI512
        Format: TW_UINT16; // Any TWFF_xxx constant
        VRefNum: TW_INT16; // Used for Mac only
        parID: TW_UINT32; // Used for Mac only
      end;
      pTW_SETUPFILEXFER2 = ^TW_SETUPFILEXFER2;
      TTWSetupFileXFER2 = TW_SETUPFILEXFER2;
      PTWSetupFileXFER2 = pTW_SETUPFILEXFER2;
     
    type
      // DAT_SETUPMEMXFER. Sets up Data Source to application data
      // transfer via a memory buffer
      TW_SETUPMEMXFER = packed record
        MinBufSize: TW_UINT32;
        MaxBufSize: TW_UINT32;
        Preferred: TW_UINT32;
      end;
      pTW_SETUPMEMXFER = ^TW_SETUPMEMXFER;
      TTWSetupMemXFER = TW_SETUPMEMXFER;
      PTWSetupMemXFER = pTW_SETUPMEMXFER;
     
    type
      TW_VERSION = packed record
        MajorNum: TW_UINT16; // Major revision number of the software.
        MinorNum: TW_UINT16; // Incremental revision number of the
        // software
        Language: TW_UINT16; // e.g. TWLG_SWISSFRENCH
        Country: TW_UINT16; // e.g. TWCY_SWITZERLAND
        Info: TW_STR32; // e.g. "1.0b3 Beta release"
      end;
      pTW_VERSION = ^TW_VERSION;
      PTWVersion = pTW_VERSION;
      TTWVersion = TW_VERSION;
     
    type
      TW_IDENTITY = packed record
        Id: TW_UINT32; // Unique number. In Windows,
        // application hWnd
        Version: TW_VERSION; // Identifies the piece of code
        ProtocolMajor: TW_UINT16; // Application and DS must set to
        // TWON_PROTOCOLMAJOR
        ProtocolMinor: TW_UINT16; // Application and DS must set to
        // TWON_PROTOCOLMINOR
        SupportedGroups: TW_UINT32; // Bit field OR combination of DG_
        // constants
        Manufacturer: TW_STR32; // Manufacturer name, e.g.
        // "Hewlett-Packard"
        ProductFamily: TW_STR32; // Product family name, e.g.
        // "ScanJet"
        ProductName: TW_STR32; // Product name, e.g. "ScanJet Plus"
      end;
      pTW_IDENTITY = ^TW_IDENTITY;
     
    type
      // DAT_USERINTERFACE. Coordinates UI between application and data
      // source
      TW_USERINTERFACE = packed record
        ShowUI: TW_BOOL; // TRUE if DS should bring up its UI
        ModalUI: TW_BOOL; // For Mac only - true if the DS's UI is modal
        hParent: TW_HANDLE; // For Windows only - Application handle
      end;
      pTW_USERINTERFACE = ^TW_USERINTERFACE;
      TTWUserInterface = TW_USERINTERFACE;
      PTWUserInterface = pTW_USERINTERFACE;
     
      ////////////////////////////////////////////////////////////////////////
      //                                                                    //
      //                END OF TWAIN TYPES AND CONSTANTS                    //
      //                                                                    //
      ////////////////////////////////////////////////////////////////////////
     
    const
      TWAIN_DLL_Name = 'TWAIN_32.DLL';
      DSM_Entry_Name = 'DSM_Entry';
      Ini_File_Name = 'WIN.INI';
      CrLf = #13 + #10;
     
    resourcestring // Errorstrings:
      ERR_DSM_ENTRY_NOT_FOUND = 'Unable to find the entry of the Data ' +
        'Source Manager in: TWAIN_32.DLL';
      ERR_TWAIN_NOT_LOADED = 'Unable to load or find: TWAIN_32.DLL';
      ERR_DSM_CALL_FAILED = 'A call to the Data Source Manager failed ' +
        'in module %s';
      ERR_UNKNOWN = 'A call to the Data Source Manager failed ' +
        'in module %s: Code %.04x';
      ERR_DSM_OPEN = 'Unable to close the Data Source Manager. ' +
        'Maybe a source is still in use';
      ERR_STATUS = 'Unable to get the status';
      ERR_DSM = 'Data Source Manager error in module %s:' +
        CrLf + '%s';
      ERR_DS = 'Data Source error in module %s:' +
        CrLf + '%s';
     
    type
      ETwainError = class(Exception);
      TImageType = (ffTIFF, ffPICT, ffBMP, ffXBM, ffJFIF, ffFPX,
        ffTIFFMULTI, ffPNG, ffSPIFF, ffEXIF, ffUNKNOWN);
      TTransferType = (xfNative, xfMemory, xfFile);
      TLanguageType = (lgDutch, lgEnglish,
        lgFrench, lgGerman,
        lgAmerican, lgItalian,
        lgSpanish, lgNorwegian,
        lgFinnish, lgDanish,
        lgRussian, lgPortuguese,
        lgSwedish, lgPolish,
        lgGreek, lgTurkish);
      TCountryType = (ctNetherlands, ctEngland,
        ctFrance, ctGermany,
        ctUSA, ctSpain,
        ctItaly, ctDenmark,
        ctFinland, ctNorway,
        ctRussia, ctPortugal,
        ctSweden, ctPoland,
        ctGreece, ctTurkey);
      TTWAIN = class(TComponent)
      private
        // Private declarations
        fBitmap: TBitmap; // the actual bmp used for
        // scanning, must be
        // removed
        HDSMDLL: HMODULE; // = 0, the library handle:
        // will stay global
        appId: TW_IDENTITY; // our (Application) ID.
        // (may stay global)
        dsId: TW_IDENTITY; // Data Source ID (will
        // become member of DS
        // class)
        fhWnd: HWND; // = 0, maybe will be
        // removed, use
        // application.handle
        // instead
        fXfer: TTransferType; // = xfNative;
        bDataSourceManagerOpen: Boolean; // = False, flag, may stay
        // global
        bDataSourceOpen: Boolean; // = False, will become
        // member of DS class
        bDataSourceEnabled: Boolean; // = False, will become
        // member of DS class
        fScanReady: TNotifyEvent; // notifies that the scan
        // is ready
        sDefaultSource: string; // remember old data source
        fOldOnMessageHandler: TMessageEvent; // Save old OnMessage event
        fShowUI: Boolean; // Show User Interface
        fSetupFileXfer: TW_SETUPFILEXFER; // Not used yet
        fSetupMemoryXfer: TW_SETUPMEMXFER; // Not used yet
        fMemory: TW_MEMORY; // Not used yet
     
        function fLoadTwain: Boolean;
        procedure fUnloadTwain;
        function fNativeXfer: Boolean;
        function fMemoryXfer: Boolean; // Not used yet
        function fFileXfer: Boolean; // Not used yet
        function fGetDestination: TTransferType;
        procedure fSetDestination(dest: TTransferType);
        function Condition2String(ConditionCode: TW_UINT16): string;
        procedure RaiseLastDataSourceManagerCondition(module: string);
        procedure RaiseLastDataSourceCondition(module: string);
        procedure TwainCheckDataSourceManager(res: TW_UINT16;
          module: string);
        procedure TwainCheckDataSource(res: TW_UINT16;
          module: string);
     
        function CallDataSourceManager(pOrigin: pTW_IDENTITY;
          DG: TW_UINT32;
          DAT: TW_UINT16;
          MSG: TW_UINT16;
          pData: TW_MEMREF): TW_UINT16;
     
        function CallDataSource(DG: TW_UINT32;
          DAT: TW_UINT16;
          MSG: TW_UINT16;
          pData: TW_MEMREF): TW_UINT16;
     
        procedure XferMech;
        procedure fSetProductname(pn: string);
        function fGetProductname: string;
        procedure fSetManufacturer(mf: string);
        function fGetManufacturer: string;
        procedure fSetProductFamily(pf: string);
        function fGetProductFamily: string;
        procedure fSetLanguage(lg: TLanguageType);
        function fGetLanguage: TLanguageType;
        procedure fSetCountry(ct: TCountryType);
        function fGetCountry: TCountryType;
        procedure SaveDefaultSourceEntry;
        procedure RestoreDefaultSourceEntry;
        procedure fSetCursor(cr: TCursor);
        function fGetCursor: TCursor;
        procedure fSetImageType(it: TImageType);
        function fGetImageType: TImageType;
        procedure fSetFilename(fn: string);
        function fGetFilename: string;
        procedure fSetVersionInfo(vi: string);
        function fGetVersionInfo: string;
        procedure fSetVersionMajor(vmaj: WORD);
        procedure fSetVersionMinor(vmin: WORD);
        function fGetVersionMajor: WORD;
        function fGetVersionMinor: WORD;
     
      protected
        procedure ScanReady; dynamic; // Notifies when image transfer is
        // ready
        procedure fNewOnMessageHandler(var Msg: TMsg;
          var Handled: Boolean); virtual;
     
      public
        // Public declarations
        constructor Create(AOwner: TComponent); override;
        destructor Destroy; override;
        procedure Acquire(aBmp: TBitmap);
        procedure OpenDataSource;
        procedure CloseDataSource;
        procedure InitTWAIN;
        procedure OpenDataSourceManager;
        procedure CloseDataSourceManager;
        function IsDataSourceManagerOpen: Boolean;
        procedure EnableDataSource;
        // Procedure TWEnableDSUIOnly(ShowUI : Boolean);
        procedure DisableDataSource;
        function IsDataSourceOpen: Boolean;
        function IsDataSourceEnabled: Boolean;
        procedure SelectDataSource;
        function IsTwainDriverAvailable: Boolean;
        function ProcessSourceMessage(var Msg: TMsg): Boolean;
     
      published
        // Published declarations
        // Properties, methods
        property Destination: TTransferType
          read fGetDestination write fSetDestination;
        property TwainDriverFound: Boolean
          read IsTwainDriverAvailable;
        property Productname: string
          read fGetProductname write fSetProductname;
        property Manufacturer: string
          read fGetManufacturer write fSetManufacturer;
        property ProductFamily: string
          read fGetProductFamily write fSetProductFamily;
        property Language: TLanguageType
          read fGetLanguage write fSetLanguage;
        property Country: TCountryType
          read fGetCountry write fSetCountry;
        property ShowUI: Boolean
          read fShowUI write fShowUI;
        property Cursor: TCursor
          read fGetCursor write fSetCursor;
        property FileFormat: TImageType
          read fGetImageType write fSetImageType;
        property Filename: string
          read fGetFilename write fSetFilename;
        property VersionInfo: string
          read fGetVersionInfo write fSetVersionInfo;
        property VersionMajor: WORD
          read fGetVersionMajor write fSetVersionMajor;
        property VersionMinor: WORD
          read fGetVersionMinor write fSetVersionMinor;
        // Events
        property OnScanReady: TNotifyEvent
          read fScanReady write fScanReady;
      end;
     
    procedure Register;
     
    type
      DSMENTRYPROC = function(pOrigin: pTW_IDENTITY;
        pDest: pTW_IDENTITY;
        DG: TW_UINT32;
        DAT: TW_UINT16;
        MSG: TW_UINT16;
        pData: TW_MEMREF): TW_UINT16; stdcall;
      TDSMEntryProc = DSMENTRYPROC;
     
    type
      DSENTRYPROC = function(pOrigin: pTW_IDENTITY;
        DG: TW_UINT32;
        DAT: TW_UINT16;
        MSG: TW_UINT16;
        pData: TW_MEMREF): TW_UINT16; stdcall;
      TDSEntryProc = DSENTRYPROC;
     
    var
      DS_Entry: TDSEntryProc = nil; // Initialize
      DSM_Entry: TDSMEntryProc = nil; // Initialize
     
    implementation
     
    //---------------------------------------------------------------------
     
    constructor TTWAIN.Create(AOwner: TComponent);
     
    begin
      inherited Create(AOwner);
      // Initialize variables
      appID.Version.Info := 'Twain component';
      appID.Version.Country := TWCY_USA;
      appID.Version.Language := TWLG_USA;
      appID.Productname := 'SimpelSoft TWAIN module'; // This is the one that you are
      // going to see in the UI
      appID.ManuFacturer := 'SimpelSoft';
      appID.ProductFamily := 'SimpelSoft components';
      appID.Version.MajorNum := 1;
      appID.Version.MinorNum := 0;
      // appID.ID := Application.Handle;
     
      fSetFilename('C:\TWAIN.BMP');
      // fSetupFileXfer.FileName := 'C:\TWAIN.TMP':
      fSetImageType(ffBMP);
      // fSetupFileXfer.Format := TWFF_BMP;
      // fSetupFileXfer.VRefNum := xx; // For Mac
      // fSetupMemoryXfer.MinBufSize := xx;
      // fSetupMemoryXfer.MaxBufSize := yy;
      // fSetupMemoryXfer.Preferred := zz;
      fMemory.Flags := TWFF_BMP;
      // fMemory.Length := SizeOf(Mem);
      // fMemory.TheMem := @Mem;
     
      // fhWnd := Application.Handle;
      fShowUI := True;
     
      HDSMDLL := 0;
      sDefaultSource := '';
      fXfer := xfNative;
      bDataSourceManagerOpen := False;
      bDataSourceOpen := False;
      bDataSourceEnabled := False;
    end;
    //---------------------------------------------------------------------
     
    destructor TTWAIN.Destroy;
     
    begin
      if bDataSourceEnabled then
        DisableDataSource;
      if bDataSourceOpen then
        CloseDataSource;
      if bDataSourceManagerOpen then
        CloseDataSourceManager;
      fUnLoadTwain; // Loose the TWAIN_32.DLL
      if sDefaultSource <> '' then
        RestoreDefaultSourceEntry; // Write old entry back in WIN.INI
      Application.OnMessage := fOldOnMessageHandler; // Restore old OnMessage
      // handler
      inherited Destroy;
    end;
    //---------------------------------------------------------------------
     
    function TTWAIN.fGetVersionMajor: WORD;
     
    begin
      Result := appID.Version.MajorNum;
    end;
    //---------------------------------------------------------------------
     
    function TTWAIN.fGetVersionMinor: WORD;
     
    begin
      Result := appID.Version.MinorNum;
    end;
    //---------------------------------------------------------------------
     
    procedure TTWAIN.fSetVersionMajor(vmaj: WORD);
     
    begin
      appID.Version.MajorNum := vmaj;
    end;
    //---------------------------------------------------------------------
     
    procedure TTWAIN.fSetVersionMinor(vmin: WORD);
     
    begin
      appID.Version.MinorNum := vmin;
    end;
    //---------------------------------------------------------------------
     
    procedure TTWAIN.fSetVersionInfo(vi: string);
     
    var
      I, L: Integer;
     
    begin
      FillChar(appID.Version.Info, SizeOf(appID.Version.Info), #0);
      L := Length(vi);
      if L = 0 then
        Exit;
      if L > 32 then
        L := 32;
      for I := 1 to L do
        appID.Version.Info[I - 1] := vi[I];
    end;
    //---------------------------------------------------------------------
     
    function TTWAIN.fGetVersionInfo: string;
     
    var
      I: Integer;
     
    begin
      Result := '';
      I := 0;
      if appID.Version.Info[I] <> #0 then
        repeat
          Result := Result + appID.Version.Info[I];
          Inc(I);
        until appID.Version.Info[I] = #0;
    end;
    //---------------------------------------------------------------------
     
    procedure TTWAIN.fSetImageType(it: TImageType);
     
    begin
      fSetupFileXfer.Format := TWFF_BMP; // Initialize
      fMemory.Flags := TWFF_BMP; // Initialize
     
      case it of
        ffTIFF:
          begin
            fSetupFileXfer.Format := TWFF_TIFF;
            fMemory.Flags := TWFF_TIFF;
          end;
        ffPICT:
          begin
            fSetupFileXfer.Format := TWFF_PICT;
            fMemory.Flags := TWFF_PICT;
          end;
        ffBMP:
          begin
            fSetupFileXfer.Format := TWFF_BMP;
            fMemory.Flags := TWFF_BMP;
          end;
        ffXBM:
          begin
            fSetupFileXfer.Format := TWFF_XBM;
            fMemory.Flags := TWFF_XBM;
          end;
        ffJFIF:
          begin
            fSetupFileXfer.Format := TWFF_JFIF;
            fMemory.Flags := TWFF_JFIF;
          end;
        ffFPX:
          begin
            fSetupFileXfer.Format := TWFF_FPX;
            fMemory.Flags := TWFF_FPX;
          end;
        ffTIFFMULTI:
          begin
            fSetupFileXfer.Format := TWFF_TIFFMULTI;
            fMemory.Flags := TWFF_TIFFMULTI;
          end;
        ffPNG:
          begin
            fSetupFileXfer.Format := TWFF_PNG;
            fMemory.Flags := TWFF_PNG;
          end;
        ffSPIFF:
          begin
            fSetupFileXfer.Format := TWFF_SPIFF;
            fMemory.Flags := TWFF_SPIFF;
          end;
        ffEXIF:
          begin
            fSetupFileXfer.Format := TWFF_EXIF;
            fMemory.Flags := TWFF_EXIF;
          end;
      end;
    end;
    //---------------------------------------------------------------------
     
    procedure TTWAIN.fSetFilename(fn: string);
     
    var
      L, I: Integer;
     
    begin
      FillChar(fSetupFileXfer.FileName, SizeOf(fSetupFileXfer.Filename), #0);
      L := Length(fn);
      if L > 0 then
        for I := 1 to L do
          fSetupFileXfer.Filename[I - 1] := fn[I];
    end;
    //---------------------------------------------------------------------
     
    function TTWAIN.fGetFilename: string;
     
    var
      I: Integer;
     
    begin
      Result := '';
      I := 0;
      if fSetupFileXfer.Filename[I] <> #0 then
        repeat
          Result := Result + fSetupFileXfer.Filename[I];
          Inc(I);
        until fSetupFileXfer.Filename[I] = #0;
    end;
    //---------------------------------------------------------------------
     
    function TTWAIN.fGetImageType: TImageType;
     
    begin
      Result := ffUNKNOWN; // Initialize
      case fSetupFileXfer.Format of
        TWFF_TIFF: Result := ffTIFF;
        TWFF_PICT: Result := ffPICT;
        TWFF_BMP: Result := ffBMP;
        TWFF_XBM: Result := ffXBM;
        TWFF_JFIF: Result := ffJFIF;
        TWFF_FPX: Result := ffFPX;
        TWFF_TIFFMULTI: Result := ffTIFFMULTI;
        TWFF_PNG: Result := ffPNG;
        TWFF_SPIFF: Result := ffSPIFF;
        TWFF_EXIF: Result := ffEXIF;
      end;
    end;
    //---------------------------------------------------------------------
     
    procedure TTWAIN.fSetCursor(cr: TCursor);
     
    begin
      Screen.Cursor := cr;
    end;
    //---------------------------------------------------------------------
     
    function TTWAIN.fGetCursor: TCursor;
     
    begin
      Result := Screen.Cursor;
    end;
    //---------------------------------------------------------------------
     
    procedure TTWAIN.fSetCountry(ct: TCountryType);
     
    begin
      case ct of
        ctDenmark: appID.Version.Country := TWCY_DENMARK;
        ctNetherlands: appID.Version.Country := TWCY_NETHERLANDS;
        ctEngland: appID.Version.Country := TWCY_BRITAIN;
        ctFinland: appID.Version.Country := TWCY_FINLAND;
        ctFrance: appID.Version.Country := TWCY_FRANCE;
        ctGermany: appID.Version.Country := TWCY_GERMANY;
        ctItaly: appID.Version.Country := TWCY_ITALY;
        ctNorWay: appID.Version.Country := TWCY_NORWAY;
        ctSpain: appID.Version.Country := TWCY_SPAIN;
        ctUSA: appID.Version.Country := TWCY_USA;
        ctRussia: appID.Version.Country := TWCY_RUSSIA;
        ctPortugal: appID.Version.Country := TWCY_PORTUGAL;
        ctSweden: appID.Version.Country := TWCY_SWEDEN;
        ctPoland: appID.Version.Country := TWCY_POLAND;
        ctGreece: appID.Version.Country := TWCY_GREECE;
        ctTurkey: appID.Version.Country := TWCY_TURKEY;
      end;
    end;
    //---------------------------------------------------------------------
     
    function TTWAIN.fGetCountry: TCountryType;
     
    begin
      Result := ctNetherlands; // Initialize
      case appID.Version.Country of
        TWCY_NETHERLANDS: Result := ctNetherlands;
        TWCY_DENMARK: Result := ctDenmark;
        TWCY_BRITAIN: Result := ctEngland;
        TWCY_FINLAND: Result := ctFinland;
        TWCY_FRANCE: Result := ctFrance;
        TWCY_GERMANY: Result := ctGermany;
        TWCY_NORWAY: Result := ctNorway;
        TWCY_ITALY: Result := ctItaly;
        TWCY_SPAIN: Result := ctSpain;
        TWCY_USA: Result := ctUSA;
        TWCY_RUSSIA: Result := ctRussia;
        TWCY_PORTUGAL: Result := ctPortugal;
        TWCY_SWEDEN: Result := ctSweden;
        TWCY_TURKEY: Result := ctTurkey;
        TWCY_GREECE: Result := ctGreece;
        TWCY_POLAND: Result := ctPoland;
      end;
    end;
    //---------------------------------------------------------------------
     
    procedure TTWAIN.fSetLanguage(lg: TLanguageType);
     
    begin
      case lg of
        lgDanish: appID.Version.Language := TWLG_DAN;
        lgDutch: appID.Version.Language := TWLG_DUT;
        lgEnglish: appID.Version.Language := TWLG_ENG;
        lgFinnish: appID.Version.Language := TWLG_FIN;
        lgFrench: appID.Version.Language := TWLG_FRN;
        lgGerman: appID.Version.Language := TWLG_GER;
        lgNorwegian: appID.Version.Language := TWLG_NOR;
        lgItalian: appID.Version.Language := TWLG_ITN;
        lgSpanish: appID.Version.Language := TWLG_SPA;
        lgAmerican: appID.Version.Language := TWLG_USA;
        lgRussian: appID.Version.Language := TWLG_RUSSIAN;
        lgPortuguese: appID.Version.Language := TWLG_POR;
        lgSwedish: appID.Version.Language := TWLG_SWE;
        lgPolish: appID.Version.Language := TWLG_POLISH;
        lgGreek: appID.Version.Language := TWLG_GREEK;
        lgTurkish: appID.Version.Language := TWLG_TURKISH;
      end;
    end;
    //---------------------------------------------------------------------
     
    function TTWAIN.fGetLanguage: TLanguageType;
     
    begin
      Result := lgDutch; // Initialize
      case appID.Version.Language of
        TWLG_DAN: Result := lgDanish;
        TWLG_DUT: Result := lgDutch;
        TWLG_ENG: Result := lgEnglish;
        TWLG_FIN: Result := lgFinnish;
        TWLG_FRN: Result := lgFrench;
        TWLG_GER: Result := lgGerman;
        TWLG_ITN: Result := lgItalian;
        TWLG_NOR: Result := lgNorwegian;
        TWLG_SPA: Result := lgSpanish;
        TWLG_USA: Result := lgAmerican;
        TWLG_RUSSIAN: Result := lgRussian;
        TWLG_POR: Result := lgPortuguese;
        TWLG_SWE: Result := lgSwedish;
        TWLG_POLISH: Result := lgPolish;
        TWLG_GREEK: Result := lgGreek;
        TWLG_TURKISH: Result := lgTurkish;
      end;
    end;
    //---------------------------------------------------------------------
     
    procedure TTWAIN.fSetManufacturer(mf: string);
     
    var
      I, L: Integer;
     
    begin
      FillChar(appID.Manufacturer, SizeOf(appID.Manufacturer), #0);
      L := Length(mf);
      if L = 0 then
        Exit;
      if L > 32 then
        L := 32;
      for I := 1 to L do
        appID.Manufacturer[I - 1] := mf[I];
    end;
    //---------------------------------------------------------------------
     
    function TTWAIN.fGetManufacturer: string;
     
    var
      I: Integer;
     
    begin
      Result := '';
      I := 0;
      if appID.Manufacturer[I] <> #0 then
        repeat
          Result := Result + appID.Manufacturer[I];
          Inc(I);
        until appID.Manufacturer[I] = #0;
    end;
    //---------------------------------------------------------------------
     
    procedure TTWAIN.fSetProductname(pn: string);
     
    var
      I, L: Integer;
     
    begin
      FillChar(appID.Productname, SizeOf(appID.Productname), #0);
      L := Length(pn);
      if L = 0 then
        Exit;
      if L > 32 then
        L := 32;
      for I := 1 to L do
        appID.Productname[I - 1] := pn[I];
    end;
    //---------------------------------------------------------------------
     
    function TTWAIN.fGetProductName: string;
     
    var
      I: Integer;
     
    begin
      Result := '';
      I := 0;
      if appID.ProductName[I] <> #0 then
        repeat
          Result := Result + appID.ProductName[I];
          Inc(I);
        until appID.ProductName[I] = #0;
    end;
    //---------------------------------------------------------------------
     
    procedure TTWAIN.fSetProductFamily(pf: string);
     
    var
      I, L: Integer;
     
    begin
      FillChar(appID.ProductFamily, SizeOf(appID.ProductFamily), #0);
      L := Length(pf);
      if L = 0 then
        Exit;
      if L > 32 then
        L := 32;
      for I := 1 to L do
        appID.ProductFamily[I - 1] := pf[I];
    end;
    //---------------------------------------------------------------------
     
    function TTWAIN.fGetProductFamily: string;
     
    var
      I: Integer;
     
    begin
      Result := '';
      I := 0;
      if appID.ProductFamily[I] <> #0 then
        repeat
          Result := Result + appID.ProductFamily[I];
          Inc(I);
        until appID.ProductFamily[I] = #0;
    end;
    //---------------------------------------------------------------------
     
    procedure TTWAIN.ScanReady;
     
    begin
      if Assigned(fScanReady) then
        fScanReady(Self);
    end;
    //---------------------------------------------------------------------
     
    procedure TTWAIN.fSetDestination(dest: TTransferType);
     
    begin
      fXfer := dest;
    end;
    //---------------------------------------------------------------------
     
    function TTWAIN.fGetDestination: TTransferType;
     
    begin
      Result := fXfer;
    end;
    //----------------------------------------------------------------------
     
    function UpCaseStr(const s: string): string;
     
    var
      I, L: Integer;
     
    begin
      Result := s;
      L := Length(Result);
      if L > 0 then
      begin
        for I := 1 to L do
          Result[I] := UpCase(Result[I]);
      end;
      // Result := s; // Minor bug, changed 23/05/03
    end;
    //----------------------------------------------------------------------
    // Internal routine
    //----------------------------------------------------------------------
     
    function GetWinDir: string;
     
    var
      WD: array[0..MAX_PATH] of Char;
      L: WORD;
     
    begin
      WD := #0;
      GetWindowsDirectory(WD, MAX_PATH);
      Result := StrPas(WD);
      L := Length(Result);
      // Remove the "" if any
      if L > 0 then
        if Result[L] = '\' then
          Result := Copy(Result, 1, L - 1);
    end;
    //----------------------------------------------------------------------
    // Internal routine
    //----------------------------------------------------------------------
     
    procedure FileFindSubDir(const ffsPath: string;
      var ffsBo: Boolean);
     
    var
      sr: TSearchRec;
     
    begin
      if FindFirst(ffsPath + '*.*', faAnyFile, sr) = 0 then
        repeat
          if sr.Name <> '.' then
            if sr.Name <> '..' then
              if sr.Attr and faDirectory = faDirectory then
              begin
                FileFindSubDir(ffsPath + '\' + sr.name, ffsBo);
              end
              else
              begin
                if UpCaseStr(ExtractFileExt(sr.Name)) = '.DS' then
                  if UpCaseStr(sr.Name) <> 'WIATWAIN.DS' then
                    ffsBo := True;
              end;
        until FindNext(sr) <> 0;
      // Error if SysUtils is not added in front of FindClose!
      SysUtils.FindClose(sr);
    end;
    //----------------------------------------------------------------------
     
    function TTWAIN.IsTwainDriverAvailable: Boolean;
     
    var
      sr: TSearchRec;
      s: string;
      Bo: Boolean;
     
    begin
      // This routine might not be failsafe!
      // Under circumstances the twain drivers found in the directory
      // %WINDOWS%\TWAIN_32*.ds and below could be not properly installed!
      Bo := False;
      s := GetWinDir + '\TWAIN_32';
      FileFindSubDir(s, Bo);
      Result := Bo;
    end;
    //---------------------------------------------------------------------
     
    procedure TTWAIN.SaveDefaultSourceEntry;
     
    var
      WinIni: TIniFile;
     
    begin
      if sDefaultSource <> '' then
        Exit;
      WinIni := TIniFile.Create(Ini_File_Name);
      sDefaultSource := WinIni.ReadString('TWAIN', 'DEFAULT SOURCE', '');
      WinIni.Free;
    end;
    //---------------------------------------------------------------------
     
    procedure TTWAIN.RestoreDefaultSourceEntry;
     
    var
      WinIni: TIniFile;
     
    begin
      if sDefaultSource = '' then
        Exit; // It is not changed by this component or it is not there...
      WinIni := TIniFile.Create(Ini_File_Name);
      WinIni.WriteString('TWAIN', 'DEFAULT SOURCE', sDefaultSource);
      WinIni.Free;
      sDefaultSource := '';
    end;
    //---------------------------------------------------------------------
     
    procedure TTWAIN.InitTWAIN;
     
    begin
      appID.ID := Application.Handle;
      fHwnd := Application.Handle;
      fLoadTwain; // Load TWAIN_32.DLL
      fOldOnMessageHandler := Application.OnMessage; // Save old pointer
      Application.OnMessage := fNewOnMessageHandler; // Set to our handler
      OpenDataSourceManager; // Open DS
    end;
    //---------------------------------------------------------------------
     
    function TTWAIN.fLoadTwain: Boolean;
     
    begin
      if HDSMDLL = 0 then
      begin
        HDSMDLL := LoadLibrary(TWAIN_DLL_Name);
        DSM_Entry := GetProcAddress(HDSMDLL, DSM_Entry_Name);
        // if @DSM_Entry = nil then
        //   raise ETwainError.Create(SErrDSMEntryNotFound);
      end;
     
      Result := (HDSMDLL <> 0);
    end;
    //---------------------------------------------------------------------
     
    procedure TTWAIN.fUnloadTwain;
     
    begin
      if HDSMDLL <> 0 then
      begin
        DSM_Entry := nil;
        FreeLibrary(HDSMDLL);
        HDSMDLL := 0;
      end;
    end;
    //---------------------------------------------------------------------
     
    function TTWAIN.Condition2String(ConditionCode: TW_UINT16): string;
     
    begin
      // Texts copied from PDF Documentation: Rework needed
      case ConditionCode of
        TWCC_BADCAP: Result :=
          'Capability not supported by source or operation (get,' + CrLf +
            'set) is not supported on capability, or capability had' + CrLf +
            'dependencies on other capabilities and cannot be' + CrLf +
            'operated upon at this time';
        TWCC_BADDEST: Result := 'Unknown destination in DSM_Entry.';
        TWCC_BADPROTOCOL: Result := 'Unrecognized operation triplet.';
        TWCC_BADVALUE: Result :=
          'Data parameter out of supported range.';
        TWCC_BUMMER: Result :=
          'General failure. Unload Source immediately.';
        TWCC_CAPUNSUPPORTED: Result := 'Capability not supported by ' +
          'Data Source.';
        TWCC_CAPBADOPERATION: Result := 'Operation not supported on ' +
          'capability.';
        TWCC_CAPSEQERROR: Result :=
          'Capability has dependencies on other capabilities and ' + CrLf +
            'cannot be operated upon at this time.';
        TWCC_DENIED: Result :=
          'File System operation is denied (file is protected).';
        TWCC_PAPERDOUBLEFEED,
          TWCC_PAPERJAM: Result :=
          'Transfer failed because of a feeder error';
        TWCC_FILEEXISTS: Result :=
          'Operation failed because file already exists.';
        TWCC_FILENOTFOUND: Result := 'File not found.';
        TWCC_LOWMEMORY: Result :=
          'Not enough memory to complete the operation.';
        TWCC_MAXCONNECTIONS: Result :=
          'Data Source is connected to maximum supported number of ' +
            CrLf + 'applications.';
        TWCC_NODS: Result :=
          'Data Source Manager was unable to find the specified Data ' +
            'Source.';
        TWCC_NOTEMPTY: Result :=
          'Operation failed because directory is not empty.';
        TWCC_OPERATIONERROR: Result :=
          'Data Source or Data Source Manager reported an error to the' +
            CrLf + 'user and handled the error. No application action ' +
            'required.';
        TWCC_SEQERROR: Result :=
          'Illegal operation for current Data Source Manager' + CrLf +
            'and Data Source state.';
        TWCC_SUCCESS: Result := 'Operation was succesful.';
      else
        Result := Format('Unknown condition %.04x', [ConditionCode]);
      end;
    end;
    ///////////////////////////////////////////////////////////////////////
    // RaiseLastDSMCondition (idea: like RaiseLastWin32Error)            //
    // Tries to get the status from the DSM and raises an exception      //
    // with it.                                                          //
    ///////////////////////////////////////////////////////////////////////
     
    procedure TTWAIN.RaiseLastDataSourceManagerCondition(module: string);
     
    var
      status: TW_STATUS;
     
    begin
      Assert(@DSM_Entry <> nil);
      if DSM_Entry(@appId, nil, DG_CONTROL, DAT_STATUS, MSG_GET, @status) <>
        TWRC_SUCCESS then
        raise ETwainError.Create(ERR_STATUS)
      else
        raise ETwainError.CreateFmt(ERR_DSM, [module,
          Condition2String(status.ConditionCode)]);
    end;
    ///////////////////////////////////////////////////////////////////////
    // RaiseLastDSCondition                                              //
    // same again, but for the actual DS                                 //
    // (should be a method of DS)                                        //
    ///////////////////////////////////////////////////////////////////////
     
    procedure TTWAIN.RaiseLastDataSourceCondition(module: string);
     
    var
      status: TW_STATUS;
     
    begin
      Assert(@DSM_Entry <> nil);
      if DSM_Entry(@appId, @dsID, DG_CONTROL, DAT_STATUS, MSG_GET, @status) <>
        TWRC_SUCCESS then
        raise ETwainError.Create(ERR_STATUS)
      else
        raise ETwainError.CreateFmt(ERR_DSM, [module,
          Condition2String(status.ConditionCode)]);
    end;
    ///////////////////////////////////////////////////////////////////////
    // TwainCheckDSM (idea: like Win32Check or GDICheck in Graphics.pas) //
    ///////////////////////////////////////////////////////////////////////
     
    procedure TTWAIN.TwainCheckDataSourceManager(res: TW_UINT16;
      module: string);
     
    begin
      if res <> TWRC_SUCCESS then
      begin
        if res = TWRC_FAILURE then
          RaiseLastDataSourceManagerCondition(module)
        else
          raise ETwainError.CreateFmt(ERR_UNKNOWN, [module, res]);
      end;
    end;
    ///////////////////////////////////////////////////////////////////////
    // TwainCheckDS                                                      //
    // same again, but for the actual DS                                 //
    // (should be a method of DS)                                        //
    ///////////////////////////////////////////////////////////////////////
     
    procedure TTWAIN.TwainCheckDataSource(res: TW_UINT16;
      module: string);
     
    begin
      if res <> TWRC_SUCCESS then
      begin
        if res = TWRC_FAILURE then
          RaiseLastDataSourceCondition(module)
        else
          raise ETwainError.CreateFmt(ERR_UNKNOWN, [module, res]);
      end;
    end;
    ///////////////////////////////////////////////////////////////////////
    // CallDSMEntry:                                                     //
    // Short form for DSM Calls: appId is not needed as parameter        //
    ///////////////////////////////////////////////////////////////////////
     
    function TTWAIN.CallDataSourceManager(pOrigin: pTW_IDENTITY;
      DG: TW_UINT32;
      DAT: TW_UINT16;
      MSG: TW_UINT16;
      pData: TW_MEMREF): TW_UINT16;
     
    begin
      Assert(@DSM_Entry <> nil);
     
      Result := DSM_Entry(@appID,
        pOrigin,
        DG,
        DAT,
        MSG,
        pData);
      if (Result <> TWRC_SUCCESS) and (DAT <> DAT_EVENT) then
      begin
      end;
    end;
    ///////////////////////////////////////////////////////////////////////
    // Short form for (actual) DS Calls. appId and dsID are not needed   //
    // (this should be a DS class method)                                //
    ///////////////////////////////////////////////////////////////////////
     
    function TTWAIN.CallDataSource(DG: TW_UINT32;
      DAT: TW_UINT16;
      MSG: TW_UINT16;
      pData: TW_MEMREF): TW_UINT16;
     
    begin
      Assert(@DSM_Entry <> nil);
      Result := DSM_Entry(@appID,
        @dsID,
        DG,
        DAT,
        MSG,
        pData);
    end;
    ///////////////////////////////////////////////////////////////////////
    //  A lot of the following code is a conversion from the             //
    //  twain example program (and some comments are copied, too)        //
    //  (The error handling is done differently)                         //
    //  Most functions should be moved to a DSM or DS class              //
    ///////////////////////////////////////////////////////////////////////
     
    procedure TTWAIN.OpenDataSourceManager;
     
    begin
      if not bDataSourceManagerOpen then
      begin
        Assert(appID.ID <> 0);
        if not fLoadTwain then
          raise ETwainError.Create(ERR_TWAIN_NOT_LOADED);
     
        // appID.Id := fhWnd;
        // appID.Version.MajorNum := 1;
        // appID.Version.MinorNum := 0;
        // appID.Version.Language := TWLG_USA;
        // appID.Version.Country  := TWCY_USA;
        // appID.Version.Info     := 'Twain Component';
        appID.ProtocolMajor := 1; // TWON_PROTOCOLMAJOR;
        appID.ProtocolMinor := 7; // TWON_PROTOCOLMINOR;
        appID.SupportedGroups := DG_IMAGE or DG_CONTROL;
        // appID.Productname      := 'HP ScanJet 5p';
        // appId.ProductFamily    := 'ScanJet';
        // appId.Manufacturer     := 'Hewlett-Packard';
     
        TwainCheckDataSourceManager(CallDataSourceManager(nil,
          DG_CONTROL,
          DAT_PARENT,
          MSG_OPENDSM,
          @fhWnd),
          'OpenDataSourceManager');
     
        bDataSourceManagerOpen := True;
      end;
    end;
    //---------------------------------------------------------------------
     
    procedure TTWAIN.CloseDataSourceManager;
     
    begin
      if bDataSourceOpen then
        raise ETwainError.Create(ERR_DSM_OPEN);
     
      if bDataSourceManagerOpen then
      begin
        // This call performs one important function:
        // - tells the SM which application, appID.id, is requesting SM to
        //   close
        // - be sure to test return code, failure indicates SM did not
        //   close !!
     
        TwainCheckDataSourceManager(CallDataSourceManager(nil,
          DG_CONTROL,
          DAT_PARENT,
          MSG_CLOSEDSM,
          @fhWnd),
          'CloseDataSourceManager');
     
        bDataSourceManagerOpen := False;
     
      end;
      fUnLoadTwain; // Loose the DLL
     
      if sDefaultSource <> '' then
        RestoreDefaultSourceEntry;
     
    end;
    //---------------------------------------------------------------------
     
    function TTWAIN.IsDataSourceManagerOpen: Boolean;
     
    begin
      Result := bDataSourceManagerOpen;
    end;
    //---------------------------------------------------------------------
     
    procedure TTWAIN.OpenDataSource;
     
    begin
      Assert(bDataSourceManagerOpen, 'Data Source Manager must be open');
     
      if not bDataSourceOpen then
      begin
        TwainCheckDataSourceManager(CallDataSourceManager(nil,
          DG_CONTROL,
          DAT_IDENTITY,
          MSG_OPENDS,
          @dsID),
          'OpenDataSource');
        bDataSourceOpen := True;
      end;
    end;
    //---------------------------------------------------------------------
     
    procedure TTWAIN.CloseDataSource;
     
    begin
      Assert(bDataSourceManagerOpen, 'Data Source Manager must be open');
      if bDataSourceOpen then
      begin
        TwainCheckDataSourceManager(CallDataSourceManager(nil,
          DG_CONTROL,
          DAT_IDENTITY,
          MSG_CLOSEDS,
          @dsID),
          'CloseDataSource');
        bDataSourceOpen := False;
      end;
    end;
    //---------------------------------------------------------------------
     
    procedure TTWAIN.EnableDataSource;
     
    var
      twUI: TW_USERINTERFACE;
     
    begin
      Assert(bDataSourceOpen, 'Data Source must be open');
     
      if not bDataSourceEnabled then
      begin
        FillChar(twUI, SizeOf(twUI), #0);
     
        twUI.hParent := fhWnd;
        twUI.ShowUI := fShowUI;
        twUI.ModalUI := True;
     
        TwainCheckDataSourceManager(CallDataSourceManager(@dsID,
          DG_CONTROL,
          DAT_USERINTERFACE,
          MSG_ENABLEDS,
          @twUI),
          'EnableDataSource');
     
        bDataSourceEnabled := True;
      end;
    end;
    //---------------------------------------------------------------------
     
    procedure TTWAIN.DisableDataSource;
     
    var
      twUI: TW_USERINTERFACE;
     
    begin
      Assert(bDataSourceOpen, 'Data Source must be open');
     
      if bDataSourceEnabled then
      begin
        twUI.hParent := fhWnd;
        twUI.ShowUI := TW_BOOL(TWON_DONTCARE8); (*!!!!*)
     
        TwainCheckDataSourceManager(CallDataSourceManager(@dsID,
          DG_CONTROL,
          DAT_USERINTERFACE,
          MSG_DISABLEDS,
          @twUI),
          'DisableDataSource');
     
        bDataSourceEnabled := False;
      end;
    end;
    //---------------------------------------------------------------------
     
    function TTWAIN.IsDataSourceOpen: Boolean;
     
    begin
      Result := bDataSourceOpen;
    end;
    //---------------------------------------------------------------------
     
    function TTWAIN.IsDataSourceEnabled: Boolean;
     
    begin
      Result := bDataSourceEnabled;
    end;
    //---------------------------------------------------------------------
     
    procedure TTWAIN.SelectDataSource;
     
    var
      NewDSIdentity: TW_IDENTITY;
      twRC: TW_UINT16;
     
    begin
      SaveDefaultSourceEntry;
      Assert(not bDataSourceOpen, 'Data Source must be closed');
     
      TwainCheckDataSourceManager(CallDataSourceManager(nil,
        DG_CONTROL,
        DAT_IDENTITY,
        MSG_GETDEFAULT,
        @NewDSIdentity),
        'SelectDataSource1');
     
      twRC := CallDataSourceManager(nil,
        DG_CONTROL,
        DAT_IDENTITY,
        MSG_USERSELECT,
        @NewDSIdentity);
     
      case twRC of
        TWRC_SUCCESS: dsID := NewDSIdentity; // log in new Source
        TWRC_CANCEL: ; // keep the current Source
      else
        TwainCheckDataSourceManager(twRC, 'SelectDataSource2');
      end;
    end;
    (*******************************************************************
      Functions from CAPTEST.C
    *******************************************************************)
     
    procedure TTWAIN.XferMech;
     
    var
      cap: TW_CAPABILITY;
      pVal: pTW_ONEVALUE;
     
    begin
      fXfer := xfNative; // Override
      cap.Cap := ICAP_XFERMECH;
      cap.ConType := TWON_ONEVALUE;
      cap.hContainer := GlobalAlloc(GHND, SizeOf(TW_ONEVALUE));
      Assert(cap.hContainer <> 0);
      try
        pval := pTW_ONEVALUE(GlobalLock(cap.hContainer));
        Assert(pval <> nil);
        try
          pval.ItemType := TWTY_UINT16;
          case fXfer of
            xfMemory: pval.Item := TWSX_MEMORY;
            xfFile: pval.Item := TWSX_FILE;
            xfNative: pval.Item := TWSX_NATIVE;
          end;
        finally
          GlobalUnlock(cap.hContainer);
        end;
     
        TwainCheckDataSource(CallDataSource(DG_CONTROL,
          DAT_CAPABILITY,
          MSG_SET,
          @cap),
          'XferMech');
     
      finally
        GlobalFree(cap.hContainer);
      end;
     
    end;
    ///////////////////////////////////////////////////////////////////////
     
    function TTWAIN.ProcessSourceMessage(var Msg: TMsg): Boolean;
     
    var
      twRC: TW_UINT16;
      event: TW_EVENT;
      pending: TW_PENDINGXFERS;
     
    begin
      Result := False;
     
      if bDataSourceManagerOpen and bDataSourceOpen then
      begin
        event.pEvent := @Msg;
        event.TWMessage := 0;
     
        twRC := CallDataSource(DG_CONTROL,
          DAT_EVENT,
          MSG_PROCESSEVENT,
          @event);
     
        case event.TWMessage of
          MSG_XFERREADY:
            begin
              case fXfer of
                xfNative: fNativeXfer;
                xfMemory: fMemoryXfer;
                xfFile: fFileXfer;
              end;
              TwainCheckDataSource(CallDataSource(DG_CONTROL,
                DAT_PENDINGXFERS,
                MSG_ENDXFER,
                @pending),
                'Check for Pending Transfers');
     
              if pending.Count > 0 then
                TwainCheckDataSource(CallDataSource(
                  DG_CONTROL,
                  DAT_PENDINGXFERS,
                  MSG_RESET,
                  @pending),
                  'Abort Pending Transfers');
     
              DisableDataSource;
              CloseDataSource;
              ScanReady; // Event
            end;
          MSG_CLOSEDSOK,
            MSG_CLOSEDSREQ:
            begin
              DisableDataSource;
              CloseDataSource;
              ScanReady // Event
            end;
        end;
     
        Result := not (twRC = TWRC_NOTDSEVENT);
      end;
    end;
    //---------------------------------------------------------------------
     
    procedure TTWAIN.Acquire(aBmp: TBitmap);
     
    begin
      // fOldOnMessageHandler := Application.OnMessage; // Save old pointer
      // Application.OnMessage := fNewOnMessageHandler; // Set to our handler
      // OpenDataSourceManager;                         // Open DS
      fBitmap := aBmp;
      OpenDataSourceManager;
      OpenDataSource;
      XferMech; // Must be written for xfMemory and xfFile
      EnableDataSource;
    end;
    //---------------------------------------------------------------------
    // Must be written!
     
    function TTWAIN.fMemoryXfer: Boolean;
     
    var
      twRC: TW_UINT16;
     
    begin
      Result := False;
      twRC := CallDataSource(DG_IMAGE,
        DAT_IMAGEMEMXFER,
        MSG_GET,
        nil);
      case twRC of
        TWRC_XFERDONE: Result := True;
        TWRC_CANCEL: ;
        TWRC_FAILURE: ;
      end;
    end;
    //---------------------------------------------------------------------
    // Must be written!
     
    function TTWAIN.fFileXfer: Boolean;
     
    var
      twRC: TW_UINT16;
     
    begin
      // Not yet implemented!
      Result := False;
      twRC := CallDataSource(DG_IMAGE,
        DAT_IMAGEFILEXFER,
        MSG_GET,
        nil);
      case twRC of
        TWRC_XFERDONE: Result := True;
        TWRC_CANCEL: ;
        TWRC_FAILURE: ;
      end;
    end;
    //---------------------------------------------------------------------
     
    function TTWAIN.fNativeXfer: Boolean;
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
      function DibNumColors(dib: Pointer): Integer;
     
      var
        lpbi: PBITMAPINFOHEADER;
        lpbc: PBITMAPCOREHEADER;
        bits: Integer;
     
      begin
        lpbi := dib;
        lpbc := dib;
     
        if lpbi.biSize <> SizeOf(BITMAPCOREHEADER) then
        begin
          if lpbi.biClrUsed <> 0 then
          begin
            Result := lpbi.biClrUsed;
            Exit;
          end;
          bits := lpbi.biBitCount;
        end
        else
          bits := lpbc.bcBitCount;
     
        case bits of
          1: Result := 2;
          4: Result := 16; // 4?
          8: Result := 256; // 8?
        else
          Result := 0;
        end;
      end;
      // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    var
      twRC: TW_UINT16;
      hDIB: TW_UINT32;
      hBmp: HBITMAP;
      lpDib: ^TBITMAPINFO;
      lpBits: PChar;
      ColorTableSize: Integer;
      dc: HDC;
     
    begin
      Result := False;
     
      twRC := CallDataSource(DG_IMAGE, DAT_IMAGENATIVEXFER, MSG_GET, @hDIB);
     
      case twRC of
        TWRC_XFERDONE:
          begin
            lpDib := GlobalLock(hDIB);
            try
              ColorTableSize := (DibNumColors(lpDib) *
                SizeOf(RGBQUAD));
     
              lpBits := PChar(lpDib);
              Inc(lpBits, lpDib.bmiHeader.biSize);
              Inc(lpBits, ColorTableSize);
     
              dc := GetDC(0);
              try
                hBMP := CreateDIBitmap(dc, lpdib.bmiHeader,
                  CBM_INIT, lpBits, lpDib^, DIB_RGB_COLORS);
     
                fBitmap.Handle := hBMP;
     
                Result := True;
              finally
                ReleaseDC(0, dc);
              end;
            finally
              GlobalUnlock(hDIB);
              GlobalFree(hDIB);
            end;
          end;
        TWRC_CANCEL: ;
        TWRC_FAILURE: RaiseLastDataSourceManagerCondition('Native Transfer');
      end;
    end;
    //---------------------------------------------------------------------
     
    procedure TTWAIN.fNewOnMessageHandler(var Msg: TMsg;
      var Handled: Boolean);
     
    begin
      Handled := ProcessSourceMessage(Msg);
      if Assigned(fOldOnMessageHandler) then
        fOldOnMessageHandler(Msg, Handled)
    end;


------------------------------------------------------------------------

Вариант 2:

Source: <https://www.swissdelphicenter.ch>

The setup program for Imaging (tool that ships with Windows \> 98)
installs the Image

Scan control (OCX) and the 32-bit TWAIN DLLs.

All you have to do is to import this ActiveX control in Delphi and
generate a component wrapper:

Import the ActiveX Control "Kodak Image Scan Control"

(Select Component\|Import ActiveX Control...)

Now add a TImgScan Component from the Register "ActiveX" to your form.

Change the following Properties in the Object Inspector:

FileType = 3 - BMP\_Bitmap
PageOption = 4 - OverwritePages
ScanTo = 2 - FileOnly

    {***}
     
     procedure TForm1.Button1Click(Sender: TObject);
     begin
       if imgScan1.ScannerAvailable then
         try
           imgScan1.Image := 'c:\Scanner.bmp';
           imgScan1.OpenScanner;
           imgScan1.Zoom := 100;
           imgScan1.StartScan;
           Application.ProcessMessages;
         finally
           imgScan1.CloseScanner;
           { Show the scanned image in Image1 }
           imgScan1.Picture.LoadFromFile(Image1.Image);
         end;
     end;


------------------------------------------------------------------------

Вариант 3:

Author: Павел, speclab@4unet.ru

Date: 12.05.2000

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

В настоящее время в конференциях то и дело встречаются вопросы типа:
как мне получить изображение со сканера, с web камеры и т.д..
При том, что и в
интернете практически полностью отсутствуют материалы по этим вопросам
на русском языке и при достаточном разнообразии их на английском. Эта
статья должна помочь начинающему программисту на Delphi разобраться в
них. В статье подробно, с примерами описана работа со сканером с
использованием популярной библиотеки Easy TWAIN.

**Введение**

В отличие от принтеров сканеры изначально не поддерживались ОС Windows и
не имеют API для работы с ними. В начале своего появления сканеры
взаимодействовали с программами посредством уникального для каждой
модели сканера интерфейса, что серьезно затрудняло включение поддержки
работы со сканером в прикладные программы.

Для решения этой проблемы был разработан TWAIN - индустриальный стандарт
интерфейса программного обеспечения для передачи изображений из
различных устройств в Windows и Macintosh. Стандарт издан и
поддерживается TWAIN рабочей группой - официальный сайт www.twain.org.
Стандарт издан в 1992 г. В настоящее время действует версия 1.9 от
января 2000 г. Абревеатура TWAIN изначально не имела какого-то
определенного смысла хотя позже была придумана расшифровка: (Technology
Without An Interesting Name - Технология без интересного имени). TWAIN -
не протокол аппаратного уровня, он требует драйвера (названного Data
Source или DS) для каждого устройства.

К настоящему времени (май 2000 г.) TWAIN доступен для Windows 3.1 и выше
(Intel и совместимые процессоры), Macintosh и OS/2. Для Linux самый
близкий стандарт - SANE.

Менеджер TWAIN (DSM) - действует как координатор между приложениями и
Источником Данных (Data Source). DSM имеет минимальный пользовательский
интерфейс - только выбор DS. Все взаимодействие с пользователем вне
прикладной программы осуществляется по средствам DS.

Каждый источник данных разрабатывается непосредственно производителем
соответствующих устройств. И их поддержка стандарта TWAIN осуществляется
на добровольной основе.

**Использование TWAIN**

DSM и DS это DLLs загружаемые в адресное пространство приложения и
работают как подпрограммы приложения. DSM использует межпроцесcную
связь, что бы координировать действия со своими копиями, когда больше
чем одна программа использует TWAIN.

Упрощенная схема действия приложения использующего TWAIN:

1. Открыть диалог настройки соответствующего устройства (диалог отображает
DS) и задать соответствующие настройки.

2. Приложение ожидает сообщение от DS, что изображение готово. Во время
ожидания все зарегистрированные сообщения будут направляться через
TWAIN. Если это не будет выполняться, то приложение не получит сообщения
о готовности изображения.

3. Приложение принимает изображение от DS.

    TWAIN определяет три типа передачи изображения:

    - Native - в Windows это DIB в памяти
    - Memory - как блоки пикселей в буферах памяти
    - File - DS записывает изображение непосредственно в файл (не обязательно
    поддерживается)

4. Приложение закрывает DS.

**Использование EZTWAIN**

Данная библиотека была разработана, что бы упростить разработку программ
использующих TWAIN предоставляя разработчику упрощенную версию TWAIN
API.

EZTWAN обеспечивает передачу всех windows сообщений через TWAIN и
ожидает сообщения о готовности изображения.

Библиотека EZTWAIN является свободно распространяемой библиотекой с
открытыми исходными кодами. В настоящее время выпущена версия 1.12.
Библиотеку можно свободно скачать с сайта: www.dosadi.com, библиотека
написана на C и предназначена для использования как DLL, необходимый для
ее использования с Delphi модуль так же можно скачать с сайта. Кроме нее
у меня с сайта можно скачать модификацию данной библиотеки,
предназначенную для статической компоновки с программой на Delphi.
Указанная версия (MultiTWAIN for Delphi) не требует наличия библиотеки
EZTW32.DLL.

**Структура программы**

Используемые функции.

Перед вызовом функций сканирования необходимо вызвать функцию:

    TWAIN_SelectImageSource(hwnd: HWND): Integer;

Данная функция позволяет выбрать источник получения данных из списка
TWAIN совместимых устройств, в качестве параметра она получает хендл
основного окна прикладной программы. Следует заменить, что если в
системе имеется одно TWAIN совместимое устройство, то вызывать функцию
не обязательно.

Для получения изображения служит функция:

    TWAIN_AcquireNative(hwnd: HWND; pixmask: Integer): HBitmap;

где:

hwnd - хендел основного окна прикладной программы (допускается указывать
0);

pixmask - режим сканирования ( необходимо задавать 0 - указание другого
режима может приводить к ошибке);

hBitmap - указатель на область памяти, содержащей полученные данные в
DIB формате.

По окончании работы с DIB данными их необходимо удалить вызвав
процедуру:

    TWAIN_FreeNative(hDIB: HBitmap);

где:

hDIB - указатель, полученный при вызове функции TWAIN\_AcquireNative.

Для облегчения обработки полученных DIB данных в библиотеке имеется
несколько сервисных функций:

    TWAIN_DibWidth(hDib: HBitmap): Integer;
    // Получает ширину изображения в пикселях
     
    TWAIN_DibHeight(hDib: HBitmap): Integer;
    // Получает высоту изображения в пикселях
     
    TWAIN_CreateDibPalette(hdib: HBitmap): Integer;
    // Получает цветовую палитру изображения
     
    TWAIN_DrawDibToDC(hDC: HDC;
      dx, dy, w, h: Integer;
      hDib: HBitmap;
      sx, sy: Integer);
    // Передает DIB данные в формате совместимым
    // с указанным контекстом устройства.

**Пример программы**

Полный текст примера можно взять отсюда:
[twain_demo.zip](twain_demo.zip) 122k

Мы рассмотрим только функцию
получения данных с TWAIN устройства:

    procedure TForm1.Accquire1Click(Sender: TObject);
    var
      dat: hBitMap;
      PInfo: PBitMapInfoHeader;
      Height, Width: integer;
     
      {Функция возведения 2 в степень s}
      function stp2(s: byte): longint;
      var
        m: longint;
        i: byte;
      begin
        m := 2;
        for i := 2 to s do
          m := m * 2;
        stp2 := m;
      end;
     
    begin
      {Получаем указатель на графические данные}
      dat := TWAIN_AcquireNative(Handle, 0);
      if dat <> 0 then
      begin
        {Получаем указатель на область памяти содержащей DIB
         данные и блокируем область памяти}
        PInfo := GlobalLock(dat);
        {Анализируем полученные данные}
        Height := PInfo.biHeight;
        Width := PInfo.biWidth;
        {Узнаем размер полученного изображения в сантиметрах}
        Wcm.Caption := floatToStrF(100 / PInfo.biXPelsPerMeter * Width, ffNumber, 8,
          3)
          + ' cm';
        Hcm.Caption := floatToStrF(100 / PInfo.biYPelsPerMeter * Height, ffNumber,
          8, 3)
          + ' cm';
        {Определяем число цветов в изображении}
        Colors.Caption := floatToStrF(stp2(PInfo.biBitCount), ffNumber, 8, 0) +
          ' цветов';
        {Разблокируем память}
        GlobalUnlock(dat);
        {Передаем в битовую матрицу графические данные}
        {И устанавливаем перехват ошибок}
        try
          MyBitMap.Palette := TWAIN_CreateDibPalette(dat);
          MyBitMap.Width := Width;
          MyBitMap.Height := Height;
          TWAIN_DrawDibToDC(MyBitMap.Canvas.Handle, 0, 0, Width, Height, dat, 0, 0);
        except
          // Обрабатываем наиболее вероятную ошибку связанную
          // с не хваткой ресурсов для загрузки изображения
          on EOutOFResources do
            MessageDlg('TBitMap: Нет ресурсов для загрузки изображения!',
              mtError, [mbOk], 0);
        end;
        {Отображаем графические данные}
        Image1.Picture.Graphic := MyBitMap;
        {Освобождаем память занятую графическими данными}
        TWAIN_FreeNative(dat);
      end;
    end;

Обработка ошибок необходима, так как объект TBitMap имеет серьезные
ограничения на размер создаваемого изображения. При этом производится
обработка наиболее вероятной ошибки, в случае возникновения другой
ошибки, ее обработка будет передана обработчику по умолчанию. Обработка
ошибки в данном случае заключается в выдаче диагностического сообщения,
в прикладной программе можно реализовать выполнение любых необходимых
действий, например, произвести уменьшение разрешения и повторно подать
на загрузку в TBitMap.

**Заключение**

Приведенный здесь пример тестировался на сканере Umax 2000P с драйвером
VistaScan32 V3.52. При получении изображений следует помнить, что
максимальный размер блока памяти, который может распределить Windows,
составляет 2 Гб и при попытке сканировании страниц формата А4 с высоким
разрешением можно превысить этот предел. Кроме того, достаточно простой
в обращении объект TBitMap имеет куда более серьезные ограничения на
размер загружаемых изображений, что требует непосредственной работы с
DIB данными. Но это уже тема для отдельной статьи.

Если у Вас появились
вопросы или предложения пишите мне: speclab@4unet.ru


