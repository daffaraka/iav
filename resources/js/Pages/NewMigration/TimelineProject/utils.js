export const getDaysRemaining = (targetDate) => {
  if (!targetDate) return { text: '', isOverdue: false };
  const target = new Date(targetDate);
  const today = new Date();
  target.setHours(0, 0, 0, 0);
  today.setHours(0, 0, 0, 0);
  
  const diffTime = target.getTime() - today.getTime();
  const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
  
  if (diffDays < 0) return { text: `Terlewat ${Math.abs(diffDays)} hari`, isOverdue: true };
  if (diffDays === 0) return { text: 'Hari ini', isOverdue: false };
  return { text: `Sisa ${diffDays} hari`, isOverdue: false };
};

export const calculateProgress = (boards = []) => {
  if (!boards || boards.length === 0) return 0;
  let totalTasks = 0;
  let doneTasks = 0;
  boards.forEach((board) => {
    const tasks = board.tasks || [];
    totalTasks += tasks.length;
    doneTasks += tasks.filter((t) => t.column_id === 'done').length;
  });
  if (totalTasks === 0) return 0;
  return Math.round((doneTasks / totalTasks) * 100);
};
