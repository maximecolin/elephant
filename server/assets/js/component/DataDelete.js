
export default class DataDelete
{
  constructor(element) {
    this.element = element;
    this.element.addEventListener('click', this.onClick.bind(this));
    this.href = this.element.getAttribute('data-delete');
  }

  onClick(event) {
    event.preventDefault();
    console.log(this.href);
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = this.href;
    const method = document.createElement('input');
    method.type = 'hidden';
    method.name = '_method';
    method.value = 'DELETE';
    form.append(method);
    document.body.appendChild(form);
    form.submit();
  }
}
