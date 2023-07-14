import Translation from './pages/Translation'
import Languages from './pages/Languages'
import Groups from './pages/Groups'

Nova.booting((app, store) => {
    Nova.inertia('Languages', Languages)
    Nova.inertia('Groups', Groups)
    Nova.inertia('Translation', Translation)
})

