<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot Kominfo</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>

<body>
    <div id="chat-container">
        <div id="chat-header">
            <img src="https://cdn-icons-png.flaticon.com/512/2343/2343177.png" alt="Bot" />
            <div>
                <strong>Lapor Infra</strong><br />
                <small>Online</small>
            </div>
        </div>
        <div id="chatbox"></div>
        <div id="options"></div>
    </div>

    <script>
        const chatbox = document.getElementById("chatbox");
        const options = document.getElementById("options");

        let step = 0;
        let topic = "";

        // Function to add a chat bubble
        function addBubble(text, type) {
            const bubble = document.createElement("div");
            bubble.className = `bubble ${type}`;
            bubble.innerHTML = text;
            chatbox.appendChild(bubble);
            chatbox.scrollTop = chatbox.scrollHeight;
            saveChat(); // Save chat state after adding a bubble
        }

        // Function to show typing indicator
        function showTyping() {
            const typing = document.createElement("div");
            typing.id = "typing";
            typing.className = "typing";
            typing.textContent = "Bot sedang mengetik...";
            chatbox.appendChild(typing);
            chatbox.scrollTop = chatbox.scrollHeight;
        }

        // Function to hide typing indicator
        function hideTyping() {
            const typing = document.getElementById("typing");
            if (typing) typing.remove();
        }

        // Function to show available options
        function showOptions(optionList) {
            options.innerHTML = "";
            optionList.forEach((opt) => {
                const btn = document.createElement("button");
                btn.className = "option-btn";
                btn.textContent = opt.label;
                btn.onclick = () => handleInput(opt);
                options.appendChild(btn);
            });

            if (step === 0) {
                const otherBtn = document.createElement("button");
                otherBtn.className = "option-btn";
                otherBtn.textContent = "Tidak ada di daftar masalah";
                otherBtn.onclick = () => {
                    addBubble("Saya tidak menemukan masalah saya di daftar.", "user");
                    showTyping();
                    setTimeout(() => {
                        hideTyping();
                        showForm();
                    }, 1000);
                };
                options.appendChild(otherBtn);
            } else if (step === 7) {
                const otherBtn = document.createElement("button");
                otherBtn.className = "option-btn";
                otherBtn.textContent = "masalah tidak terselesaikan";
                otherBtn.onclick = () => {
                    addBubble("masalah tidak terselesaikan.", "user");
                    showTyping();
                    setTimeout(() => {
                        hideTyping();
                        showForm();
                    }, 1000);
                };
                options.appendChild(otherBtn);
            }
        }
        // Function to show the form for user input
        function showForm() {
            const formContainer = document.createElement("div");

            // Tambahkan ke chatbox dulu supaya elemen `#opd-select` sudah ada di DOM
            chatbox.appendChild(formContainer);

            formContainer.innerHTML = `
        <div class="bubble bot">
            Silakan isi form berikut agar kami bisa menghubungi Anda:
            <form id="customForm" style="margin-top:10px;">
                <input type="text" placeholder="Nama Anda" name="nama" required />
                <select id="opd-select" name="opd" required style="width:100%; margin:5px 0; padding:5px;">
                    <option value="">Pilih OPD</option>
                </select>
                <input type="text" placeholder="Permasalahan" name="masalah" required />
                <textarea placeholder="Deskripsi Singkat" name="deskripsi" required></textarea>
                <input type="text" placeholder="Kontak yang bisa dihubungi (WA/Email)" name="kontak" required />
                <button type="submit">Kirim</button>
            </form>
        </div>    
    `;

            // Setelah elemen ditambahkan, baru fetch data OPD
            fetch("/get-opds")
                .then(response => response.json())
                .then(data => {
                    const opdSelect = formContainer.querySelector("#opd-select");
                    data.forEach(opd => {
                        const option = document.createElement("option");
                        option.value = opd.nama;
                        option.textContent = opd.nama;
                        opdSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error("Gagal memuat data OPD:", error);
                });

            chatbox.scrollTop = chatbox.scrollHeight;

            // Tambahkan event listener untuk form submit
            formContainer.querySelector("form").addEventListener("submit", async (e) => {
                e.preventDefault();
                const data = new FormData(e.target);

                const nama = data.get("nama");
                const opd = data.get("opd");
                const masalah = data.get("masalah");
                const deskripsi = data.get("deskripsi");
                const kontak = data.get("kontak");

                addBubble(
                    `Nama: ${nama}<br>OPD: ${opd}<br>Masalah: ${masalah}<br>Deskripsi: ${deskripsi}<br>Kontak: ${kontak}`,
                    "user"
                );

                showTyping();
                options.innerHTML = "";

                try {
                    const response = await fetch("/lapor", {
                        method: "POST",
                        body: data,
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        },
                    });

                    const result = await response.json();

                    hideTyping();
                    addBubble(result.message || "Terima kasih! Laporan Anda telah kami terima.", "bot");
                    showOptions(getMainOptions());
                    e.target.reset();
                    saveChat();
                } catch (err) {
                    hideTyping();
                    addBubble("Gagal mengirim laporan. Silakan coba lagi nanti.", "bot");
                }
            });
        }


        // Handle user input and trigger next steps
        function handleInput(input) {

            addBubble(input.label, "user");
            let response = "";
            let nextOptions = [];

            if (step === 0) {
                topic = input.value;
                if (topic === "jaringan") {
                    response = "Masalah Jaringan apa yang kamu alami?";
                    nextOptions = [{
                            label: "Jaringan Lemot",
                            value: "lemot"
                        },
                        {
                            label: "Jaringan Sering Putus",
                            value: "putus"
                        },
                    ];
                    step = 1;
                } else if (topic === "sinyal") {
                    response = "Gangguan sinyal seperti apa?";
                    nextOptions = [{
                            label: "Hilang Total",
                            value: "hilang"
                        },
                        {
                            label: "Sinyal Lemah",
                            value: "lemah"
                        },
                    ];
                    step = 10;
                } else if (topic === "website") {
                    response = "Apakah website tidak bisa dibuka di semua perangkat?";
                    nextOptions = [{
                            label: "Ya",
                            value: "ya"
                        },
                        {
                            label: "Tidak",
                            value: "tidak"
                        },
                    ];
                    step = 20;
                } else if (topic === "perangkat") {
                    response = "Apakah perangkat tidak terdeteksi di jaringan lokal?";
                    nextOptions = [{
                            label: "Ya",
                            value: "ya"
                        },
                        {
                            label: "Tidak",
                            value: "tidak"
                        },
                    ];
                    step = 30;
                }
            } else if (step === 1) {
                if (input.value === "lemot") {
                    response = "Apakah semua perangkat lemot?";
                    nextOptions = [{
                            label: "Ya",
                            value: "ya"
                        },
                        {
                            label: "Tidak",
                            value: "tidak"
                        },
                    ];
                    step = 2;
                } else {
                    response = "Masalah terjadi di jam tertentu?";
                    nextOptions = [{
                            label: "Ya",
                            value: "ya"
                        },
                        {
                            label: "Tidak",
                            value: "tidak"
                        },
                    ];
                    step = 3;
                }
            } else if (step === 2) {
                response =
                    input.value === "ya" ?
                    "Solusi: Restart router, pastikan tidak ada pembatasan bandwidth. Hubungi ISP jika tetap bermasalah." :
                    "Solusi: Periksa perangkat yang digunakan. Bisa jadi aplikasi berat atau gangguan lokal.";
                nextOptions = [{
                    label: "Kembali ke menu utama",
                    value: "reset"
                }];
                step = 7;
            } else if (step === 3) {
                response =
                    input.value === "ya" ?
                    "Solusi: Kemungkinan pembatasan dari ISP saat jam sibuk. Gunakan di jam lain atau hubungi ISP." :
                    "Solusi: Cek kondisi kabel dan router.";
                nextOptions = [{
                    label: "Kembali ke menu utama",
                    value: "reset"
                }];
                step = 7;
            } else if (step === 10) {
                response =
                    input.value === "hilang" ?
                    "Solusi: Coba pindah lokasi ke area terbuka. Jika tetap, hubungi provider untuk cek BTS." :
                    "Solusi: Cek mode hemat daya dan posisi antena ponsel.";
                nextOptions = [{
                    label: "Kembali ke menu utama",
                    value: "reset"
                }];
                step = 7;
            } else if (step === 20) {
                response =
                    input.value === "ya" ?
                    "Solusi: Kemungkinan website down. Coba gunakan VPN atau cek di perangkat lain." :
                    "Solusi: Periksa DNS perangkat atau clear cache browser.";
                nextOptions = [{
                    label: "Kembali ke menu utama",
                    value: "reset"
                }];
                step = 7;
            } else if (step === 30) {
                response =
                    input.value === "ya" ?
                    "Solusi: Pastikan koneksi LAN/Wi-Fi, dan periksa IP address serta firewall." :
                    "Solusi: Lakukan ping ke perangkat lain, jika terhubung cek visibilitas jaringan.";
                nextOptions = [{
                    label: "Kembali ke menu utama",
                    value: "reset"
                }];
                step = 7;
            }

            if (input.value === "reset") {
                response = "Pilih topik permasalahan:";
                nextOptions = getMainOptions();
                step = 0;
            }

            showTyping();
            options.innerHTML = "";
            setTimeout(() => {
                hideTyping();
                addBubble(response, "bot");
                showOptions(nextOptions);
            }, 1000);
        }

        function getMainOptions() {
            return [{
                    label: "Masalah Jaringan",
                    value: "jaringan"
                },
                {
                    label: "Gangguan Sinyal",
                    value: "sinyal"
                },
                {
                    label: "Tidak Bisa Akses Website",
                    value: "website"
                },
                {
                    label: "Perangkat Tidak Terdeteksi",
                    value: "perangkat"
                },
            ];
        }




        // Load chat and state on window load
        window.onload = () => {
            loadChat(); // Load saved chat if any

            if (!localStorage.getItem("kominfo_chat")) {
                addBubble("Halo! Saya Kominfo Bot, siap membantu Anda.", "bot");
                setTimeout(() => {
                    addBubble("Pilih topik permasalahan yang kamu alami:", "bot");
                    showOptions(getMainOptions());
                }, 700);
            } else {
                const savedData = JSON.parse(localStorage.getItem("kominfo_chat"));

                chatbox.innerHTML = ""; // Kosongkan dulu
                savedData.chat.forEach(bubble => {
                    addBubble(bubble.text, bubble.type); // Tambahkan kembali secara aman
                });

                step = savedData.step;
                topic = savedData.topic;
                showOptions(getMainOptions());

                chatbox.scrollTop = chatbox.scrollHeight;
            }
        };

        // Function to save chat state to localStorage
        function saveChat() {
            const bubbles = Array.from(chatbox.children).map(b => ({
                type: b.classList.contains("bot") ? "bot" : "user",
                text: b.querySelector(".text")?.innerHTML || b.innerHTML // fleksibel
            }));

            const chatData = {
                chat: bubbles,
                step: step,
                topic: topic
            };

            localStorage.setItem("kominfo_chat", JSON.stringify(chatData));
        }

        function loadChat() {
            const saved = JSON.parse(localStorage.getItem("kominfo_chat"));
            if (saved && Array.isArray(saved.chat)) {
                chatbox.innerHTML = ""; // Kosongkan dulu
                saved.chat.forEach(bubble => {
                    addBubble(bubble.text, bubble.type); // Tambahkan bubble secara aman
                });
                step = saved.step;
                topic = saved.topic;
                chatbox.scrollTop = chatbox.scrollHeight;
            } else {
                localStorage.removeItem("kominfo_chat"); // hapus data rusak
            }
        }
    </script>
</body>

</html>
