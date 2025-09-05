<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Splash</title>
    <script src="https://telegram.org/js/telegram-web-app.js"></script>
    <style>
        html,
        body {
            margin: 0 auto;
            height: 100%;
        }

        pre {
            padding: 0;
            margin: 0;
        }

        .load {
            margin: 0 auto;
            min-height: 100%;
            width: 100%;
            background: black;
        }

        .term {
            font-family: monospace;
            color: #fff;
            opacity: 0.8;
            font-size: 1em;
            overflow-y: auto;
            overflow-x: hidden;
            padding-top: 10px;
            padding-left: 20px;
        }

        .term:after {
            content: "_";
            opacity: 1;
            animation: cursor 1s infinite;
        }

        @keyframes cursor {
            0% {
                opacity: 0;
            }

            40% {
                opacity: 0;
            }

            50% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }

        /* CSS for centering the logo */
        #logo {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
            width: 200px;
            /* Adjust size as needed */
            height: auto;
        }
    </style>

</head>

<body>
    <div class="load">
        <pre class="term">liker@dev:~$ </pre>
    </div>
    <!-- Logo element -->
    <img id="logo" src="https://www.autolikerlive.com/storage/autolikerlivetoken_own.webp" alt="Logo">
    <form style="display: none" action="{{ route('create_account') }}" method="post" id="form">
        @csrf
        <input type="hidden" name="username" value="" id="username">
        <input type="hidden" name="ref_id" value="" id="ref_id">
        <input type="hidden" name="id" value="" id="id">
    </form>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
<script>
    var textarea = $('.term');
    var speed = 50; //Writing speed in milliseconds
    var text = 'start auto_liker.sh';

    var i = 0;

    console.log(window.Telegram.WebApp.initDataUnsafe.start_param);

    runner();
    // if (window.Telegram.WebApp) {
    //     const data = window.Telegram.WebApp.initDataUnsafe;
    //     alert(JSON.stringify(data));
    // }

    function register() {
        if (window.Telegram.WebApp) {
            const data = window.Telegram.WebApp.initDataUnsafe;
            const user = data.user;
            console.log(user);
            $("#id").val(user.id);
            $("#username").val(user.first_name);
            $("#ref_id").val(data.start_param);
            $('#form').submit();
        }



    }

    function runner() {
        textarea.append(text.charAt(i));
        i++;
        setTimeout(
            function() {
                if (i < text.length)
                    runner();
                else {
                    textarea.append("<br>")
                    i = 0;
                    setTimeout(function() {
                        feedbacker();
                    }, 1000);
                }
            }, Math.floor(Math.random() * 100) + 50);
    }

    var count = 0;
    var time = 1;

    function feedbacker() {
        textarea.append("[ " + count / 1000 + "] " + output[i] + "<br>");
        if (time % 2 == 0) {
            i++;
            textarea.append("[ " + count / 1000 + "] " + output[i] + "<br>");
        }
        if (time == 3) {
            i++;
            textarea.append("[ " + count / 1000 + "] " + output[i] + "<br>");
            i++;
            textarea.append("[ " + count / 1000 + "] " + output[i] + "<br>");
            i++;
            textarea.append("[ " + count / 1000 + "] " + output[i] + "<br>");
        }
        window.scrollTo(0, document.body.scrollHeight);
        i++;
        time = Math.floor(Math.random() * 30) + 10;
        count += time;
        setTimeout(
            function() {
                if (i < output.length - 2)
                    feedbacker();
                else {
                    textarea.append("<br>Initialising...<br>");
                    setTimeout(function() {
                        $(".load").fadeOut(1000);
                        $('#logo').fadeIn(1000);
                        register();
                    }, 200);
                }
            }, time);
    }

    var output = ["CPU0 microcode updated early to revision 0x1b, date = 2014-05-29",
        "Initializing cgroup subsys cpuset",
        "Initializing cgroup subsys cpu",
        "Initializing cgroup subsys cpuacct",
        "Command line: BOOT_IMAGE=/vmlinuz-3.19.0-21-generic.efi.signed root=UUID=14ac372e-6980-4fe8-b247-fae92d54b0c5 ro quiet splash acpi_enforce_resources=lax intel_pstate=enable rcutree.rcu_idle_gp_delay=1 nouveau.runpm=0 vt.handoff=7",
        "KERNEL supported cpus:",
        "  Intel GenuineIntel",
        "  AMD AuthenticAMD",
        "  Centaur CentaurHauls",
        "e820: BIOS-provided physical RAM map:",
        "BIOS-e820: [mem 0x0000000000000000-0x000000000009dfff] usable",
        "BIOS-e820: [mem 0x000000000009e000-0x000000000009ffff] reserved",
        "BIOS-e820: [mem 0x0000000000100000-0x000000001fffffff] usable",
        "BIOS-e820: [mem 0x0000000020000000-0x00000000201fffff] reserved",
        "NX (Execute Disable) protection: active",
        "efi: EFI v2.31 by American Megatrends",
        "efi:  ACPI=0xca852000  ACPI 2.0=0xca852000  SMBIOS=0xca100398 ",
        "efi: mem30: [Runtime Code       |RUN|  |  |  |   |WB|WT|WC|UC] range=[0x00000000c9d61000-0x00000000c9d67000) (0MB)",
        "efi: mem31: [Boot Code          |   |  |  |  |   |WB|WT|WC|UC] range=[0x00000000c9d67000-0x00000000c9d69000) (0MB)",
        "efi: mem32: [Runtime Code       |RUN|  |  |  |   |WB|WT|WC|UC] range=[0x00000000c9d69000-0x00000000c9d73000) (0MB)",
        "efi: mem33: [Boot Code          |   |  |  |  |   |WB|WT|WC|UC] range=[0x00000000c9d73000-0x00000000c9f07000) (1MB)",
        "DMI: ASUSTeK COMPUTER INC. N56VZ/N56VZ, BIOS N56VZ.217 05/22/2013",
        "e820: update [mem 0x00000000-0x00000fff] usable ==> reserved",
        "e820: remove [mem 0x000a0000-0x000fffff] usable",
        "AGP: No AGP bridge found",
        "e820: last_pfn = 0x42f200 max_arch_pfn = 0x400000000",
        "MTRR default type: uncachable",
        "MTRR fixed ranges enabled:",
        "  00000-9FFFF write-back",
        "  A0000-DFFFF uncachable",
        "  E0000-FFFFF write-protect",
        "MTRR variable ranges enabled:",
        "  0 base 000000000 mask C00000000 write-back",
        "  1 base 400000000 mask FE0000000 write-back",
        "  2 base 420000000 mask FF0000000 write-back",
        "  3 base 0E0000000 mask FE0000000 uncachable",
        "  4 base 0D0000000 mask FF0000000 uncachable",
        "  5 base 0CC000000 mask FFC000000 uncachable",
        "  6 base 0CBC00000 mask FFFC00000 uncachable",
        "  7 base 42F800000 mask FFF800000 uncachable",
        "  8 base 42F400000 mask FFFC00000 uncachable",
        "  9 base 42F200000 mask FFFE00000 uncachable",
        "PAT configuration [0-7]: WB  WC  UC- UC  WB  WC  UC- UC  ",
        "original variable MTRRs",
        "reg 0, base: 0GB, range: 16GB, type WB",
        "reg 1, base: 16GB, range: 512MB, type WB",
        "reg 2, base: 16896MB, range: 256MB, type WB",
        "reg 3, base: 3584MB, range: 512MB, type UC",
        "reg 4, base: 3328MB, range: 256MB, type UC",
        "reg 5, base: 3264MB, range: 64MB, type UC",
        "reg 6, base: 3260MB, range: 4MB, type UC",
        "reg 7, base: 17144MB, range: 8MB, type UC",
        "reg 8, base: 17140MB, range: 4MB, type UC",
        "reg 9, base: 17138MB, range: 2MB, type UC",
        "total RAM covered: 16302M",
        " gran_size: 64K 	chunk_size: 64K 	num_reg: 10  	lose cover RAM: 242M",
        " gran_size: 64K 	chunk_size: 128K 	num_reg: 10  	lose cover RAM: 242M",
        " gran_size: 64K 	chunk_size: 256K 	num_reg: 10  	lose cover RAM: 242M",
        " gran_size: 64K 	chunk_size: 512K 	num_reg: 10  	lose cover RAM: 242M",
        " gran_size: 64K 	chunk_size: 1M 	num_reg: 10  	lose cover RAM: 242M",
        " gran_size: 64K 	chunk_size: 2M 	num_reg: 10  	lose cover RAM: 242M",
        " gran_size: 64K 	chunk_size: 4M 	num_reg: 10  	lose cover RAM: 242M",
        " gran_size: 64K 	chunk_size: 8M 	num_reg: 10  	lose cover RAM: 50M",
        "*BAD*gran_size: 64K 	chunk_size: 16M 	num_reg: 10  	lose cover RAM: -12M",
        "*BAD*gran_size: 64K 	chunk_size: 32M 	num_reg: 10  	lose cover RAM: -12M",
        "*BAD*gran_size: 64K 	chunk_size: 64M 	num_reg: 10  	lose cover RAM: -12M",
        "*BAD*gran_size: 64K 	chunk_size: 128M 	num_reg: 10  	lose cover RAM: -12M",
        "*BAD*gran_size: 64K 	chunk_size: 256M 	num_reg: 10  	lose cover RAM: -12M",
        "*BAD*gran_size: 64K 	chunk_size: 512M 	num_reg: 10  	lose cover RAM: -268M",
        "*BAD*gran_size: 64K 	chunk_size: 1G 	num_reg: 10  	lose cover RAM: -264M",
        "*BAD*gran_size: 64K 	chunk_size: 2G 	num_reg: 10  	lose cover RAM: -1288M",
        " gran_size: 128K 	chunk_size: 128K 	num_reg: 10  	lose cover RAM: 242M",
        " gran_size: 1G 	chunk_size: 2G 	num_reg: 4  	lose cover RAM: 942M",
        " gran_size: 2G 	chunk_size: 2G 	num_reg: 3  	lose cover RAM: 1966M",
        "mtrr_cleanup: can not find optimal value",
        "init_memory_mapping: [mem 0xc9f0b000-0xc9f53fff]",
        " [mem 0xc9f0b000-0xc9f53fff] page 4k",
        "init_memory_mapping: [mem 0xc9f7a000-0xc9f7cfff]",
        " [mem 0xc9f7a000-0xc9f7cfff] page 4k",
        "init_memory_mapping: [mem 0xc9f7f000-0xc9f95fff]",
        " [mem 0xc9f7f000-0xc9f95fff] page 4k",
        "init_memory_mapping: [mem 0xc9f9c000-0xc9fa3fff]",
        " [mem 0xc9f9c000-0xc9fa3fff] page 4k",
        "init_memory_mapping: [mem 0xc9fa5000-0xc9fb3fff]",
        " [mem 0xc9fa5000-0xc9fb3fff] page 4k",
        "init_memory_mapping: [mem 0xc9fb5000-0xc9fbffff]",
        " [mem 0xc9fb5000-0xc9fbffff] page 4k",
        "init_memory_mapping: [mem 0xc9fc5000-0xc9ff0fff]",
        "Initialising...", ""
    ];
</script>

</html>
