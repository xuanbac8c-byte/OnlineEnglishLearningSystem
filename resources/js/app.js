document.getElementById('toggleCourses').addEventListener('click', function () {
    const wrapper = document.getElementById('coursesWrapper');
    wrapper.classList.toggle('expanded');
    this.textContent = wrapper.classList.contains('expanded') ? 'Thu gọn' : 'Xem thêm';
});