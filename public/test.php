<td class="process edit-item" data-id="${item.id}" data-key="oil_no">${item.oil_no}</td>
<td class="process edit-item" data-id="${item.id}" data-key="oil_name">${item.oil_name}</td>
<td class="process edit-item" data-id="${item.id}" data-key="detail">${item.detail}</td>
<td class="process edit-item" data-id="${data.id}" data-key="unit">${item.unit}</td>
<td class="process edit-item" data-id="${item.id}" data-key="price">${item.price}</td>
<td class="process " >${item.how_much}</td>
<td class="process " >${item.total}</td>
<td class="operate table-operate">
    <a class="edit" href="javascript:;">查看</a>
    <a class="del" href="javascript:;">删除</a>
</td>
<div class="tanhuang-equ" style="display: block;">
    <ul>
        {{each (j,info) infowarning}}
        <li>${info.equ_oil_name} 用量:${info.quantity} 润滑日期:${info.del_warning_time}</li>
        {{/each}}
    </ul>
</div>