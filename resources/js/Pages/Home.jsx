import GuestLayout from '@/Layouts/GuestLayout';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

export default function Home({ auth }) {
    return (
        <div>
            <h1 className="text-2xl">
                {auth.user ? `Bem-vindo de volta, ${auth.user.name}` : 'Bem-vindo ao nosso site!'}
            </h1>
        </div>
    );
}

Home.layout = (page) =>
    page.props.auth.user
        ? <AuthenticatedLayout children={page} />
        : <GuestLayout children={page} />;
