<div class="grid grid-cols-1 md:grid-cols-1 gap-6 mt-8">
    <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Bảng phân ca</h2>
            <select name="" id="" class="form-control w-fit">
                <option value="">Nhân viên nhận đơn</option>
                <option value="">Nhân viên bán hàng</option>
            </select>
            <div class="flex items-center">
                <button class="btn bg-green-100 text-green-500 py-2 px-4 rounded-lg mr-1 hover:bg-green-500 hover:text-white">Xuất <i class="fa-solid fa-table"></i></button>
                <button class="btn bg-blue-100 text-blue-500 py-2 px-4 rounded-lg ml-1 hover:bg-blue-500 hover:text-white">In <i class="fa-solid fa-print"></i></button>
            </div>
        </div>

        <div class="h-fit bg-blue-100 rounded-lg p-4">
            <div id="calendar"></div>

            <div id="info" class="hidden">
                <h2 class="font-bold text-xl py-1">Thông tin ca làm</h2>
                <div id="details"></div>
            </div>

            <?php
            $currentDate = new DateTime();
            $currentWeekDay = $currentDate->format('w');

            $startW = clone $currentDate;
            $startW->modify('-' . ($currentWeekDay - 1) . ' days');

            $endW = clone $startW;
            $endW->modify('+13 days');

            $startW = $startW->format('Y-m-d');
            $endW = $endW->format('Y-m-d');

            $sql = "SELECT * FROM `employee_shift` AS ES JOIN `user` AS U ON ES.userID = U.userID JOIN `shift` AS S ON S.shiftID = ES.shiftID WHERE ES.date BETWEEN '$startW' AND '$endW'";
            $result = $conn->query($sql);
            $workShifts = [];

            while ($row = $result->fetch_assoc()) {
                $workShifts[$row["date"]][] = [
                    "employee" => $row["userName"],
                    "time" => $row["shiftName"]
                ];
            }

            $jsonWorkShifts = json_encode($workShifts);
            ?>

        </div>
    </div>

    <script>
        const workShifts = <?php echo $jsonWorkShifts; ?>;

        function createCalendar() {
            const calendar = document.getElementById("calendar");

            const startW = new Date("<?php echo $startW; ?>");
            const endW = new Date("<?php echo $endW; ?>");

            for (let day = new Date(startW); day <= endW; day.setDate(day.getDate() + 1)) {
                const dateString = day.toISOString().split('T')[0];

                const dayDiv = document.createElement("div");
                dayDiv.classList.add("day");
                dayDiv.textContent = day.getDate();

                if (workShifts[dateString]) {
                    const dot = document.createElement("div");
                    dot.classList.add("dot");
                    dot.style.display = "block";
                    dayDiv.appendChild(dot);

                    dayDiv.onclick = () => showInfoShift(dateString);
                }

                calendar.appendChild(dayDiv);
            }
        }

        function showInfoShift(date) {
            const infoDiv = document.getElementById("info");
            const detailsDiv = document.getElementById("details");
            const shifts = workShifts[date];

            detailsDiv.innerHTML = `<p class='mb-3'><strong>Ngày:</strong> ${date}</p>`;

            if (shifts) {
                shifts.forEach(shift => {
                    detailsDiv.innerHTML += `<div class='flex items-center mb-2'><button class='bg-gray-300 size-8 p-1 text-center mr-4 rounded-full'><i class="fa-solid fa-minus"></i></button><span>${shift.employee} (${shift.time})</span> <button class='bg-gray-300 size-8 p-1 text-center ml-4 rounded-full'><i class="fa-solid fa-wrench"></i></button></div>`;
                });
                
                detailsDiv.innerHTML += `<div class='flex items-center mb-2'><button class='bg-gray-300 size-8 p-1 text-center mr-4 rounded-full'><i class="fa-solid fa-plus"></i></button><span class='text-gray-600'>Thêm nhân viên</span></div>`;
            } else {
                detailsDiv.innerHTML += `<p>Không có thông tin ca làm cho ngày này.</p>`;
            }

            infoDiv.classList.remove("hidden");
        }

        createCalendar();
    </script>