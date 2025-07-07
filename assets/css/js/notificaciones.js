document.addEventListener('DOMContentLoaded', () => {
  const notifDropdown = document.getElementById('notifDropdown');
  if (notifDropdown) {
    notifDropdown.addEventListener('show.bs.dropdown', () => {
      fetch('/sisec-ui/views/notificaciones/marcar_notificaciones_vistas.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' }
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          const badge = notifDropdown.querySelector('.notification-badge');
          if (badge) badge.remove();
        }
      })
      .catch(console.error);
    });
  }
});
