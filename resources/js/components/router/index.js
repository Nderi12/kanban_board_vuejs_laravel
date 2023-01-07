// import {
//     createRouter,
//     createWebHistory
// } from 'vue-router';
import kanban from '../kanban/Kanban.vue'

const routes = [
    // {
    //     name: "login",
    //     path: "/login",
    //     component: Login,
    //     meta: {
    //         middleware: "guest",
    //         title: `Login`
    //     }
    // },
    {
        children: [
            {
                name: "kanbanBoard",
                path: '/kanban-dashboard',
                component: kanban,
                meta: {
                    title: `KanbanDashboard`
                }
            }
        ]
    }
]

// const router = createRouter({
//     history: createWebHistory(
//         import.meta.env.BASE_URL),
//     routes, // short for `routes: routes`
// });

// export default router;
